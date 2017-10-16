/**
 * Created by emilianozublena on 16/10/17.
 */
console.log('main loaded');
const baseUrl = $('body').data('baseUrl');

$('.bookDelete').click(function () {
    var $el = $(this);
    const bookId = $(this).data('bookId');
    console.log('bookDelete on Click');
    $.ajax({
        url: 'books/' + bookId,
        method: 'DELETE',
        //headers: this.state.headers,
        dataType: 'json',
        contentType: false,
        processData: false,
        statusCode: {
            204: function(){
                alert('You\'ve successfully deleted the book ' + bookId);
                $el.closest('.book').remove();
            },
            400: function(){
                alert('There\'s been an error deleting the book ' + bookId);
            }
        }

    });
});

$('.shelfDelete').click(function () {
    var $el = $(this);
    const shelfId = $(this).data('shelfId');
    console.log('shelfDelete on Click');
    $.ajax({
        url: 'shelves/' + shelfId,
        method: 'DELETE',
        //headers: this.state.headers,
        dataType: 'json',
        contentType: false,
        processData: false,
        statusCode: {
            204: function(){
                alert('You\'ve successfully deleted the shelf ' + shelfId);
                $el.closest('.shelf').remove();
            },
            400: function(){
                alert('There\'s been an error deleting the shelf ' + shelfId);
            }
        }

    });
});

//if all of the items have changed, we should use put since put is for replacing a whole repository
//if none items changed, we return null to avoid unnecessary calls to the server
const getMethodAndBodyFromComparedData = function(formData, origFormData){
    if(
        formData.name == origFormData.name &&
        formData.author == origFormData.author &&
        formData.shelf_id == origFormData.shelf_id
    ) {
        return {
            method: null,
            formData: null
        };
    }else if(
        formData.name != origFormData.name &&
        formData.author != origFormData.author &&
        formData.shelf_id != origFormData.shelf_id
    ){
        return {
            method: 'PUT',
            formData: formData
        };
    }else {
        var returnFormData = {};
        if(formData.name != origFormData.name) {
            returnFormData.name = formData.name;
        }
        if(formData.author != origFormData.author) {
            returnFormData.author = formData.author;
        }
        if(formData.shelf_id != origFormData.shelf_id) {
            returnFormData.shelf_id = formData.shelf_id;
        }
        return {
            method: 'PATCH',
            formData: returnFormData
        };
    }
};

$('#updateBookForm').submit(function(ev){
    ev.preventDefault();
    var $form = $(this);
    const formData = {
        name: $('input[name="name"]').val(),
        author: $('input[name="author"]').val(),
        shelf_id: $('input[name="shelf_id"]').val()
    };
    const origFormData = {
        name: $('input[name="orig_name"]').val(),
        author: $('input[name="orig_author"]').val(),
        shelf_id: $('input[name="orig_shelf_id"]').val()
    };
    const request = getMethodAndBodyFromComparedData(formData, origFormData);
    if(request.method === null) {
        alert('You\'ve changed nothing!');
    }else {
        $.ajax({
            url: $form.attr('action'),
            method: request.method,
            //headers: this.state.headers,
            dataType: 'json',
            data: JSON.stringify(request.formData),
            contentType: false,
            processData: false,
            statusCode: {
                200: function(){
                    alert('You\'ve successfully updated the book');
                },
                204: function(){
                    alert('No book by the id');
                },
                400: function(){
                    alert('There\'s been an error updating the shelf ');
                }
            }

        });
    }
});