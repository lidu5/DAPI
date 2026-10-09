import request from '@/utils/request';
import Resource from '@/api/resource';

class DHPI extends Resource {
  constructor() {
    super('projects');
  }

  retire(id, resource) {
    return request({
      url: '/retire/' + id,
      method: 'put',
      data: resource,
    });
  }

  delete(id) {
    return request({
      url: '/' + this.uri + '/' + id,
      method: 'delete',
    });
  }
  
  resource(id, resource) {
    return request({
      url: '/' + this.uri + '/' + id + '/resource',
      method: 'post',
      data: resource,
    });
  }

  logo(id, resource) {
    return request({
      url: '/' + this.uri + '/' + id + '/logo',
      method: 'post',
      data: resource,
    });
  }

  impact_evaluation(id, resource) {
    return request({
      url: '/' + this.uri + '/' + id + '/impact_evaluation',
      method: 'post',
      data: resource,
    });
  }

  deleteType(id, resource) {
    return request({
      url: '/' + this.uri + '/' + id + '/type',
      method: 'delete',
      data: resource,
    });
  }

  requestRegistration(id) {
    return request({
      url: '/' + this.uri + '/' + id + '/request_registration',
      method: 'put'
    });
  }


  withdrawRegistration(id) {
    return request({
      url: '/' + this.uri + '/' + id + '/withdraw_registration',
      method: 'put'
    });
  }

  request_cert_comp(id) {
    return request({
      url: '/' + this.uri + '/' + id + '/request_cert_comp',
      method: 'put'
    });
  }
  
  publish(id) {
    return request({
      url: '/' + this.uri + '/' + id + '/publish',
      method: 'put'
    });
  }

archive(id) {
  return request({
    url: '/' + this.uri + '/' + id + '/archive',
    method: 'post'
  });
}

unarchive(projectId) {
  return request({
    url: `/projects/${projectId}/unarchive`,
    method: 'POST',
  });
}

  getProjectWithUuid(uuid) {
    return request({
      url: '/project/' + uuid,
      method: 'get'
    });
  }
}

export { DHPI as default };
