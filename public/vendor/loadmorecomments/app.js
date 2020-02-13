$( document ).ready(function() {

  $(document).on('click', '#btnLoadMoreComments', function() {
    loadNextComments()
  });

  function loadNextComments() {
    var currentPage = $("#btnLoadMoreComments").data('page');
    var tricksId = $("#btnLoadMoreComments").data('tricksid');
    tricksId = (tricksId) == undefined ? 0 : tricksId;
    jQuery.ajax({
      url: 'comments/ajax',
      data: 'page='+currentPage+'&id='+tricksId,
      type: 'POST',
      success: function(data) {
        var data = JSON.parse(JSON.stringify(data));

        $('#commentsResult').append(data.html);
        $("#btnLoadMoreComments").data('page', data.page);
        if(data.hideButton) {
          $("#btnLoadMoreComments").hide();
        }

      }
    });
  }

  loadNextComments();
});
