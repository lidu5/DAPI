pipeline {
     agent {
        label 'builtin-linux'
    }

    options {
        timestamps()
        disableConcurrentBuilds()
        skipDefaultCheckout(true)
    }
    stages {
        stage('Checkout') {
            steps { checkout scm }
        }
        stage('Deploy') {
            steps {
                sshagent(credentials: ['dapi-deploy-key']) {
                    sh 'ssh -o StrictHostKeyChecking=accept-new moa@172.28.21.161 "/opt/dapi-app/deploy.sh"'
                }
            }
        }
    }
    post {
        success { echo 'Deployed successfully' }
        failure { echo 'Deployment failed - check the console output' }
    }
}