'use strict';

$(function(){
  let $previewImage = $('.js-image-preview img');
  let $previewContainer = $('.js-image-preview');
  let $fileInput = $('.js-resize-image-file');
  let $imageHiddenField = $('.js-image-field');
  let imageHelper = new ImageHelper(320, 240);

  $fileInput.on('change', function () {
    let loadedFile = this.files[0];
    let reader = new FileReader();

    reader.onload = function (e) {
      let image = new Image();
      image.src = e.target.result;
      image.onload = function () {
        let canvasUrl = imageHelper.getScaledImageDataUrl(
          this,
          image.naturalWidth,
          image.naturalHeight
        );
        $previewImage[0].src = canvasUrl;
        $imageHiddenField.val(canvasUrl.replace(/^data:image\/(png|jpg|jpeg);base64,/, ""));
        $previewContainer.css('display', 'block');
      };
    }

    reader.readAsDataURL(loadedFile);
  });

  $('.js-task-preview').on('click', function(){
    let taskView = new TaskView(
      $('.js-userName').val(),
      $('.js-Email').val(),
      $('.js-description').val(),
      'NEW',
      $previewImage[0].src
    );

    taskView.renderPopup();
  })
})