        $(document).ready(function($){
             $(".unfavorite").click(function(){
    var a=$(this).attr("data-action");
    var o=$(this).attr("content");
      var user=$("#auth_user_login").val();
      //   alert(a);
      //   alert(o);
      // alert(user);
     if(user!=''){
    $.ajax({
        type:"GET",
        url:web_url+"/favourites/remove-favorite",
        data:{instance_id:a,category_id:o},
    
        success:function(o){
            $("#unfav-"+a).hide();
             $("#unfavorite-"+a).hide();
                // $("#fav-item-"+o).remove(),
                $("#fav-"+a).show();
            
        }
    });
}else{
     $('.user_login ').modal('show');
}
});
        });
     
        $(document).ready(function($){
      $(".favorite").click(function(){
    var a=$(this).attr("data-action");
    var o=$(this).attr("content");
    var user=$("#auth_user_login").val();
      /*alert(o);
       alert(a);
      alert(user);*/
    if(user!=''){
 $.ajax({
        type:"GET",
        url:web_url+"/favourites/add-favorite",
        data:{instance_id:a,category_id:o},
       
        success:function(){
           $("#unfav-"+a).show();
                // $("#fav-item-"+o).remove(),
                $("#fav-"+a).hide();
                 $("#favorite-"+a).hide();
        }
    });
    }else{
        $('.user_login ').modal('show');
    }

});
    });