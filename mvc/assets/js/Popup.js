'use strict'

class Popup {
  constructor() {
    this.template = `
    <div id='popup' class="modal js-modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close js-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title js-title" id="myModalLabel"></h4>
                </div>    
           
                <div class="modal-body js-body">
                </div>
            </div>
        </div>
    </div>  
`;
    this.selector = $(this.template);
    this.bodySelector = this.selector.find('.js-body');
    this.closeBtn = this.selector.find('.js-close');
    this.modalTitle = this.selector.find('.js-title');
    $('body').append(this.selector);
    this.closeBtn.on('click', () => {this.close();});
  }


  show(title, $content) {
    this.modalTitle.html(title);
    this.bodySelector.empty();
    this.bodySelector.append($content);
    this.selector.css('display', 'block');
    this.selector.removeClass('fade');
    this.selector.addClass('fade-in');
  }

  close() {
    this.selector.css('display', 'none');
    this.selector.addClass('fade');
    this.selector.removeClass('fade-in');
  }
}

$(function(){
  window.popup = new Popup();
})