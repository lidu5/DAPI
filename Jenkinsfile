pipeline {
    agent any

    environment {
        // ── Registry & image ──────────────────────────────────────────────────
        REGISTRY        = "registry.moa.gov.et"           // change to your registry or Docker Hub user
        IMAGE_NAME      = "${REGISTRY}/dhpi-app"
        IMAGE_TAG       = "${BUILD_NUMBER}"
        IMAGE_LATEST    = "${IMAGE_NAME}:latest"
        IMAGE_VERSIONED = "${IMAGE_NAME}:${IMAGE_TAG}"

        // ── Remote deploy target ──────────────────────────────────────────────
        DEPLOY_HOST     = "172.28.21.161"
        DEPLOY_USER     = "moa"                            // SSH user on remote server
        DEPLOY_DIR      = "/opt/dapi-app"                  // working directory on remote

        // ── Credentials (configure these in Jenkins Credentials Manager) ──────
        REGISTRY_CRED   = "docker-registry-creds"          // Username+Password credential ID
        SSH_CRED        = "deploy-server-ssh-key"          // SSH Private Key credential ID
    }

    options {
        timestamps()
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    docker.build("${IMAGE_VERSIONED}", "--no-cache .")
                    docker.build("${IMAGE_LATEST}", ".")
                }
            }
        }

        stage('Push to Registry') {
            steps {
                script {
                    docker.withRegistry("https://${REGISTRY}", "${REGISTRY_CRED}") {
                        docker.image("${IMAGE_VERSIONED}").push()
                        docker.image("${IMAGE_LATEST}").push()
                    }
                }
            }
        }

        stage('Deploy to 172.28.21.161') {
            steps {
                withCredentials([sshUserPrivateKey(
                    credentialsId: "${SSH_CRED}",
                    keyFileVariable: 'SSH_KEY',
                    usernameVariable: 'SSH_USER'
                )]) {
                    // Copy compose file and env to remote
                    sh """
                        scp -o StrictHostKeyChecking=no -i \$SSH_KEY \
                            docker-compose.prod.yml \
                            \$SSH_USER@${DEPLOY_HOST}:${DEPLOY_DIR}/docker-compose.prod.yml
                    """

                    // Pull new image and restart stack
                    sh """
                        ssh -o StrictHostKeyChecking=no -i \$SSH_KEY \$SSH_USER@${DEPLOY_HOST} '
                            set -e
                            cd ${DEPLOY_DIR}

                            # Export image tag so compose uses versioned image
                            export APP_IMAGE=${IMAGE_VERSIONED}

                            # Log in to registry
                            docker login ${REGISTRY} -u \$(cat /run/secrets/reg_user) -p \$(cat /run/secrets/reg_pass) || true

                            # Pull updated image
                            docker pull ${IMAGE_VERSIONED}

                            # Bring up / recreate only the app service (DB/Redis stay running)
                            docker compose -f docker-compose.prod.yml up -d --no-deps --build app

                            # Run migrations
                            docker exec dhpi_app php artisan migrate --force

                            # Clear & warm caches
                            docker exec dhpi_app php artisan config:cache
                            docker exec dhpi_app php artisan route:cache
                            docker exec dhpi_app php artisan view:cache
                        '
                    """
                }
            }
        }
    }

    post {
        success {
            echo "✅ Deployment to ${DEPLOY_HOST} succeeded — build #${BUILD_NUMBER}"
        }
        failure {
            echo "❌ Deployment FAILED — check logs above"
        }
    }
}
