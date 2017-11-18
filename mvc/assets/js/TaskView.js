'use strict';

class TaskView {
  constructor (userName, email, description, status, image) {
    this.template = `
     <h3>Task for {{userName}}</h3>
     <p><b>Status:</b> {{status}}</p>
     <p><b>Email:</b> {{email}}</p>
     <p>
        {{#if image}}
            <img src="{{image}}" class="mg-rounded" />
        {{/if}}
        {{description}}
      </p>
`
    this.data = {
      userName: userName,
      email: email,
      description: description,
      image: typeof image !== 'undefined' ? image : null,
      status: status
    }
  }

  renderPopup() {
    let template = Handlebars.compile(this.template);
    let compiled = template(this.data);
    let element = $(compiled);
    window.popup.show('Task preview', element);
  }
}