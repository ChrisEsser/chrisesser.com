$(document).ready(function(){

    $("[data-trigger=confirm]").click(function(){

        var button = $(this);
        var url = button.data('url');
        var title = button.data('title');
        var message = button.data('message');

        if(title) { $("#confirmModal .modal-title").html(title); }
        if(message) { $("#confirmModal .modal-body").html(message); }
        $("#confirmModal form").attr('action', url);

        $("#confirmModal").modal();
    });

    //confirm post
    $("[data-trigger=confirmPost]").click(function(){

        var button = $(this);
        var id = button.data('modalId');
        $("#"+id).modal();
    });

    //confirm delete
    $("[data-trigger=confirmDelete]").click(function() {

        var button = $(this);
        var url = button.data('url');
        var title = button.data('title');
        var name = button.data('name');

        if(title) { $("#deleteModal .modal-title").html(title); }
        if(name) { $("#deleteModal .modal-body .name").html(name); }
        $("#deleteModal form").attr('action', url);

        $("#deleteModal").modal();
    });

    //generic modal
    $("[data-trigger=genericModal]").click(function() {

        var button = $(this);
        var url = button.data('url');
        var title = button.data('title');
        var content = button.data('content');

        if(title) { $("#deleteModal .modal-title").html(title); }
        if(message) { $("#genericModal .modal-body").html(content); }
        $("#genericModal form").attr('action', url);

        $("#genericModal").modal();
    });

});
