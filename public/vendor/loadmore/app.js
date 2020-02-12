$( document ).ready(function() {

  $(document).on('click', '#btnLoadMore', function() {
    loadNextTricks()
  });

  function loadNextTricks() {
    var currentPage = $("#btnLoadMore").data('page');
    jQuery.ajax({
      url: 'tricks/ajax',
      data: 'page='+currentPage,
      type: 'POST',
      success: function(data) {
        var data = JSON.parse(JSON.stringify(data));
      
        $('#tricksResult').append(data.html);
        $("#btnLoadMore").data('page', data.page);
        if(data.hideButton) {
          $("#btnLoadMore").hide();
        }

      }
    });
  }

  loadNextTricks();
});
