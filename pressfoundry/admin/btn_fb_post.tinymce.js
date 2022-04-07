(function () {
    'use strict';
    

    tinymce.create("tinymce.plugins.btn_fb_post", {

        //url argument holds the absolute url of our plugin directory
        init: function (editor, url) {
            //add new button

            editor.addButton("btn_fb_post", {
                title: "Facebook post embedding",
                image: url + '/btn_fb_post.svg',
                onclick: function settingsPopup() {
                    var caption = editor.selection.getContent(),
                        element = editor.selection.getNode(),
                        initial_href = '',
                        initial_width = 300;

                    if (caption.length < 1 && element && element.innerText) {
                        caption = element.innerText;
                    }

                    if (element && element.tagName && (element.tagName === 'div' || element.tagName === 'DIV')) {

                        initial_width = element.getAttribute('data-width') || 300;
                        initial_href = element.getAttribute('data-href') || caption;

                    }


                    editor.execCommand('btn_fb_post_popup', editor, {
                        href: initial_href,
                        width: initial_width
                    });
                }
            });

            // lets add popup
            editor.addCommand('btn_fb_post_popup', function renderSettingsPopup(editor, v, onsubmit_callback) {

                var href, width, popupWindow;

                if (v.href) {
                    href = v.href;
                }

                if (v.width) {
                    width = v.width;
                }


                if (typeof onsubmit_callback !== 'function') {
                    // set default callback
                    onsubmit_callback = function buttonInsertionDialogSubmitted(event) {

                        var el = document.createElement('div'),
                            data = event.data;

                        el.setAttribute('class','fb-post');

                        if (typeof  data.href!== 'undefined') {
                            el.setAttribute('data-href', data.href);
                        }

                        if (typeof  data.width!== 'undefined') {
                            el.setAttribute('data-width', data.width);
                        }


                        var selectedNode = editor.selection.getNode();
                        if (selectedNode && selectedNode.tagName && (selectedNode.tagName === 'div' || selectedNode.tagName === 'DIV' )) {

                            editor.selection.dom.replace(el, selectedNode);

                        } else {
                            var div = document.createElement('div');
                            div.appendChild(el);
                            editor.insertContent(div.innerHTML);
                        }


                    }
                }

                popupWindow = editor.windowManager.open({
                    title: 'Insert Facebook Post',
                    body: [
                        {
                            type: 'textbox',
                            name: 'href',
                            label: 'URL To Facebook Post',
                            value: href,
                            tooltip: 'Example'
                        },
                        {
                            type: 'textbox',
                            name: 'width',
                            label: 'Post Width',
                            tooltip: 'Enter width in pixels',
                            value: width
                        },
                    ],
                    onSubmit: onsubmit_callback
                });

            });


        },

        getInfo: function () {
            return {
                longname: "Facebook Embedded Posts",
                author: "Pressfoundry",
                version: "1"
            };
        }
    });


    tinymce.PluginManager.add("btn_fb_post", tinymce.plugins.btn_fb_post);


})(jQuery, tinymce);