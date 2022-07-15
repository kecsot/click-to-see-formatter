(function ($, Drupal) {
  Drupal.behaviors.clickToSee = {
    clickToSeePressed: function (item)  {
      if(item){
        let element = $(item);
        if(element){
          let content = element.parent().find('.click-to-see-content');
          if(content){
            content.removeClass('hide');
            element.empty()
          }
        }
      }
    },
  };
})(jQuery, Drupal);
