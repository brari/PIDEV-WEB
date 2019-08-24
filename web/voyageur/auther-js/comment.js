/* 
 * Seif v1.0
 * This is an overwrite to the bootbox and blockui js plugins.
 */
/* 
 Author     : Seif
 */

(function ($)
{
    $.extend({
        alert: function (parameters) {
            bootbox.dialog({
                message: parameters.message,
                title: "Ouups!",
                buttons: {
                    dismiss: {
                        label: "Ok",
                        className: "btn-sm btn-primary"
                    }
                },
                onEscape: function () {
                    $.hideAll();
                }
            });
        },
        serverError: function () {
            $.hideAll();
            $.unblockPage();
            bootbox.dialog({
                message: "Une erreur est survenue. Veuillez contacter votre administrateur système. (Code: #500)",
                title: "Ouups!",
                buttons: {
                    dismiss: {
                        label: "Ok",
                        className: "btn-sm btn-primary"
                    }
                },
                onEscape: function () {
                    $.hideAll();
                }
            });
        },
        confirm: function (parameters, callback) {
            bootbox.dialog({
                message: parameters.message,
                title: parameters.title,
                buttons: {
                    success: {
                        label: "Oui",
                        className: "btn-sm btn-default",
                        callback: function () {
                            callback(true);
                        }
                    },
                    danger: {
                        label: "Non",
                        className: "btn-sm btn-primary",
                        callback: function () {
                            callback(false);
                        }
                    }
                },
                onEscape: function () {
                    $.hideAll();
                }
            });
        },
        prompt: function (parameters, callback, def) {
            var def_form = parameters.label + ': <input id="popup-btn" type="text" />';
            if (typeof (def) == 'undefined') {
                def = true;
            }
            if (def == true) {
                bootbox.dialog({
                    message: def_form,
                    title: parameters.title,
                    buttons: {
                        success: {
                            label: "Ok",
                            className: "btn-sm btn-default",
                            callback: function () {
                                callback($('#popup-btn').val());
                            }
                        }
                    },
                    onEscape: function () {
                        $.hideAll();
                    }
                })
            } else if (def == false) {
                bootbox.dialog({
                    message: parameters.form,
                    title: parameters.title,
                    buttons: parameters.buttons,
                    onEscape: function () {
                        $.hideAll();
                    }
                })
            }
        },
        dialog: function (parameters) {
            bootbox.dialog({
                message: parameters.message,
                title: parameters.title,
                className: parameters.className,
                buttons: parameters.buttons,
                onEscape: function () {
                    $.hideAll();
                }
            });
        },
        hideAll: function () {
            bootbox.hideAll();
        },
        blockPage: function () {
            $.blockUI({message: ' '});
        },
        unblockPage: function () {
            $.unblockUI();
        },
        multiPress: function (keys, handler) {
            'use strict';
            if (keys.length === 0) {
                return;
            }

            var down = {};
            $(document).keydown(function (event) {
                down[event.keyCode] = true;
            }).keyup(function (event) {
                // Copy keys array, build array of pressed keys
                var remaining = keys.slice(0),
                        pressed = Object.keys(down).map(function (num) {
                    return parseInt(num, 10);
                }),
                        indexOfKey;
                // Remove pressedKeys from remainingKeys
                $.each(pressed, function (i, key) {
                    if (down[key] === true) {
                        down[key] = false;
                        indexOfKey = remaining.indexOf(key);
                        if (indexOfKey > -1) {
                            remaining.splice(indexOfKey, 1);
                        }
                    }
                });
                // If we hit all the keys, fire off handler
                if (remaining.length === 0) {
                    handler(event);
                }
            });
        }
    })
})(jQuery);


var Tva = function (parameters) {
    var _params = parameters;
    var objects = {
        form: {
            _submit_update: function (form) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'PUT',
                    data: form.serialize(),
                    success: function (response) {
                        if (response.error == true) {
                            $('.bootbox-body').html(response.content);
                        } else {
                            window.location.reload();
                        }
                    }
                });
            },
            _submit_delete: function (form) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'DELETE',
                    data: form.serialize(),
                    success: function (response) {
                        if (response.error == true) {
                            $('.bootbox-body').html(response.content);
                        } else {
                            window.location.reload();
                        }
                    }
                });
            },
            _bind: function () {
                $(document).on('submit', '.update-comment-form', function (e) {
                    e.preventDefault();
                    objects.form._submit_update($(this));
                });
                $(document).on('submit', '.delete-comment-form', function (e) {
                    e.preventDefault();
                    objects.form._submit_delete($(this));
                });
            },
            _init: function () {
                objects.form._bind();
            }
        },
        popup: {            
            _update_client: function (id) {
                $.ajax({
                    url: Routing.generate('forum_comment_edit', {comment: id}),
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (response) {
                        $.dialog({
                            message: response.content,
                            title: response.title,
                            buttons: {
                                cancel: {
                                    label: "Annuler",
                                    className: "btn-sm btn-default",
                                },
                                success: {
                                    label: "Modifier",
                                    className: "btn-sm btn-primary",
                                    callback: function () {
                                        $('.update-comment-form').submit();
                                        return false;
                                    }
                                }
                            }
                        });
                    },
                    complete: function () {
                        setTimeout(function () {
                            $('.input-comment-name').focus();
                        }, 500);
                    }
                });
            },
            _delete_client: function (id) {
                console.log(id)
                $.ajax({
                    url: Routing.generate('forum_comment_delete', {comment: id}),
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (response) {
                        $.dialog({
                            message: response.content,
                            title: response.title,
                            buttons: {
                                success: {
                                    label: "Supprimer",
                                    className: "btn-sm btn-primary",
                                    callback: function () {
                                        $('.delete-comment-form').submit();
                                        return false;
                                    }
                                },
                                cancel: {
                                    label: "Annuler",
                                    className: "btn-sm btn-default",
                                }
                            }
                        });
                    }
                });
            },
            _bind: function () {                
                $('.update-comment').on('click', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    objects.popup._update_client(id);
                });
                $('.delete-comment').on('click', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    objects.popup._delete_client(id);
                });
            },
            _init: function () {
                objects.popup._bind();
            }
        }
    };
    return {
        init: function () {
            objects.form._init();
            objects.popup._init();
        }
    };
};
