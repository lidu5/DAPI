import request from '@/utils/request';
import Resource from '@/api/resource';

class Evaluation extends Resource {
  constructor() {
    super('evaluation');
  }
  approve_registration(id, resource) {
    return request({
      url: '/' + this.uri + '/approve_registration/' + id,
      method: 'post',
      data: resource,
    });
  }
  cert_competence(id, resource) {
    return request({
      url: '/' + this.uri + '/cert_competence/' + id,
      method: 'post',
      data: resource,
    });
  }
  decline_messages(id) {
    return request({
      url: '/' + this.uri + '/decline_messages/' + id,
      method: 'get'
    });
  }
  decline_registration(id, resource) {
    return request({
      url: '/' + this.uri + '/decline_registration/' + id,
      method: 'post',
      data: resource,
    });
  }
  decline_cert_comp(id, resource) {
    return request({
      url: '/' + this.uri + '/decline_cert_comp/' + id,
      method: 'post',
      data: resource,
    });
  }
}

export { Evaluation as default };
