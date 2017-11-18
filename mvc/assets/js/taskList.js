$(function(){
  $('.js-task-in-list-preview').on('click', function(){
    let taskView = new TaskView(
      $(this).data('user-name'),
      $(this).data('email'),
      $(this).data('description'),
      $(this).data('status'),
      $(this).data('image'),
    );

    taskView.renderPopup();
  })
})