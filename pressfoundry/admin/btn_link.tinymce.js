(function (){
    'use strict';

    var linkBtnTypes= [
        {text: 'Generic button', value:'btn'},
        {text: 'Primary button', value:'btn btn-primary'},
        {text: 'Custom Color button', value:'btn btn-colored'},
        {text: 'Link', value:'btn btn-link'},
        {text: 'Inline text', value:'inline-text'},
        // {text: 'btn', value:'btn'},
        // {text: 'btn-default', value:'btn btn-default'},
        // {text: 'btn-primary', value:'btn btn-primary'},
        // {text: 'btn-success', value:'btn btn-success'},
        // {text: 'btn-warning', value:'btn btn-warning'},
        // {text: 'btn-danger', value:'btn btn-danger'},
        // {text: 'btn-info', value:'btn btn-info'}
    ];

    tinymce.create("tinymce.plugins.btn_link", {

        //url argument holds the absolute url of our plugin directory
        init : function(editor, url) {
            //add new button

            editor.addButton("btn_link", {
                title : "Link Button",
                image : url+'/btn_link.svg',
                onclick: function linkBtnSettingsPopup(){
                    var caption = editor.selection.getContent(),
                        element = editor.selection.getNode(),
                        initial_href = '#',
                        initial_buttonType = 'linkBtn',
                        initial_hasArrow = '',
                        initial_textColor = '',
                        initial_bgColor = '',
                        initial_classes = '',
                        initial_target = '_blank',
                        allElementClasses='';

                    if(caption.length<1 && element && element.innerText){
                        caption = element.innerText;
                    }

                    if(element && element.tagName  && (element.tagName ==='a' || element.tagName==='A') ){

                        initial_href = element.getAttribute('href');

                        if( element.getAttribute('target') ){
                            initial_target = element.getAttribute('target');
                        }

                        // lets parse our classes to fill in appropriate types to selectors
                        if( element.getAttribute('class') ){
                            // lets deal with classlist
                            allElementClasses = element.getAttribute('class');

                            // // text color
                            // if(element.classList.contains('dark')){
                            //     initial_textColor = 'dark';
                            // }
                            // allElementClasses = allElementClasses.replace(' dark', ' '); // remove it from class list
                            //
                            // if(element.classList.contains('light')){
                            //     initial_textColor = 'light';
                            // }
                            // allElementClasses = allElementClasses.replace(' light', ' ');
                            //
                            // // deal with arrows
                            // if(element.classList.contains('hasLeftArrow') ){
                            //     initial_hasArrow = 'hasLeftArrow';
                            // }
                            //
                            // if( element.classList.contains('hasRightArrow') ){
                            //     initial_hasArrow = 'hasRightArrow';
                            // }
                            //
                            // if(element.classList.contains('hasLeftArrow') && element.classList.contains('hasRightArrow') ){
                            //     initial_hasArrow = 'hasLeftArrow hasRightArrow';
                            // }
                            // allElementClasses = allElementClasses.replace(' hasLeftArrow', ' ');
                            // allElementClasses = allElementClasses.replace(' hasRightArrow', ' ');

                            // lets parse linkBtn classes in reverse to deal with inherited classes first.
                            var typesCount = linkBtnTypes.length;
                            while(typesCount>=0){
                                typesCount--;
                                // iterate here
                                var currentType = linkBtnTypes[typesCount].value;
                                if( allElementClasses.indexOf(currentType) > -1 ){
                                    initial_buttonType = currentType;
                                    allElementClasses = allElementClasses.replace(currentType, ' ');
                                    break;
                                }
                            }


                        }

                        if( element.getAttribute('style') ){
                            initial_bgColor = element.style.backgroundColor || '';
                            initial_textColor = element.style.color || '';
                        }

                        initial_classes = allElementClasses.trim();

                    }


                    editor.execCommand('btn_link_popup',editor,{
                        caption: caption,
                        buttonType: initial_buttonType,
                        textColor: initial_textColor,
                        bgColor: initial_bgColor,
                        // hasArrow:initial_hasArrow,
                        classes:initial_classes,
                        href:initial_href,
                        target:initial_target
                    });
                }
            });

            // lets add popup
            editor.addCommand('btn_link_popup', function renderButtonEditorPopup (editor, v, onsubmit_callback){

                var caption, buttonType, classes, href, target, popupWindow, textColor, bgColor, hasArrow;

                if(v.caption){
                    caption = v.caption;
                }

                if(v.buttonType){
                    buttonType = v.buttonType;
                }

                if(v.href){
                    href = v.href;
                }

                if(v.classes){
                    classes = v.classes;
                }

                if(v.target){
                    target = v.target;
                }

                if(v.textColor){
                    textColor = v.textColor;
                }
                if(v.bgColor){
                    bgColor = v.bgColor;
                }
                //
                // if(v.hasArrow){
                //     hasArrow = v.hasArrow;
                // }


                if(typeof onsubmit_callback !== 'function'){
                    // set default callback
                    onsubmit_callback = function buttonLinkInsertionDialogSubmitted(event){

                        var a = document.createElement('a'),
                            allClasses = '',
                            data = event.data;

                        if (typeof data.href !=='undefined' && data.href.length > 0) {
                            a.setAttribute('href', data.href);
                        }
                        if (typeof  data.buttonType !=='undefined') {
                            allClasses += ' ' + data.buttonType + ' ';
                        }

                        //
                        // if (typeof  data.hasArrow !=='undefined') {
                        //     allClasses += ' ' + data.hasArrow + ' ';
                        // }

                        if (typeof  data.classes !=='undefined' && data.classes.length>1) {
                            allClasses += ' ' + data.classes + ' ';
                        }

                        a.setAttribute( 'class', allClasses );

                        if (typeof  data.target !=='undefined') {
                            a.setAttribute('target', data.target);
                        }

                        if (typeof  data.bgColor !=='undefined') {
                            a.style.backgroundColor = data.bgColor;
                        }

                        if (typeof  data.textColor !=='undefined') {
                            a.style.color = data.textColor;
                        }


                        if (typeof  data.caption!=='undefined') {
                            a.innerText = data.caption;
                        }


                        var selectedNode = editor.selection.getNode();
                        if( selectedNode && selectedNode.tagName && (selectedNode.tagName ==='a' || selectedNode.tagName ==='A' ) ){

                            editor.selection.dom.replace( a, selectedNode);

                        }else{
                            var div = document.createElement('div');
                            div.appendChild(a);
                            editor.insertContent(div.innerHTML);
                        }



                    }
                }

                popupWindow = editor.windowManager.open({
                    title: 'Insert Link Button',
                    body:[
                        {
                            type: 'textbox',
                            name: 'caption',
                            label: 'Caption',
                            value: caption,
                            tooltip: 'Text inside button'
                        },
                        {
                            type:'listbox',
                            name: 'buttonType',
                            label: 'Button type',
                            tooltip: 'Choose button type',
                            value: buttonType,
                            values:  linkBtnTypes

                        },
                        // {
                        //     type: 'listbox',
                        //     name: 'textColor',
                        //     label: 'Text Color',
                        //     value: textColor,
                        //     values:[
                        //         {text:'Default', value: ''},
                        //         {text:'Dark', value: 'dark'},
                        //         {text:'Light', value: 'light'}
                        //     ]
                        // },
                        // {
                        //     type: 'listbox',
                        //     name: 'hasArrow',
                        //     label: 'Has arrow:',
                        //     value: hasArrow,
                        //     values:[
                        //         {text:'None', value: ''},
                        //         {text:'Right', value: 'hasRightArrow'},
                        //         {text:'Left', value: 'hasLeftArrow'},
                        //         {text:'Both', value: 'hasLeftArrow hasRightArrow'}
                        //     ]
                        // },
                        {
                            type: 'textbox',
                            name: 'href',
                            label: 'URL',
                            value: href
                        },
                        {
                            type: 'textbox',
                            name: 'classes',
                            label: 'Additional CSS classes',
                            tooltip: 'Enter classes added to button if needed',
                            value: classes
                        },
                        {
                            type: 'listbox',
                            name: 'target',
                            label: 'Open in',
                            value: target,
                            values:[
                                {text:'new tab _blank', value: '_blank'},
                                {text:'this window _self', value: '_self'}
                            ]
                        },
                        {
                            type   : 'colorbox',//'colorpicker',
                            name   : 'textColor',
                            label  : 'Text Color',
                            value: textColor,
                            onaction: createColorPickAction(),
                        },
                        {
                            type   : 'colorbox',//'colorpicker',
                            name   : 'bgColor',
                            label  : 'Background Color',
                            value: bgColor,
                            onaction: createColorPickAction(),
                        }
                    ],
                    onSubmit:  onsubmit_callback
                });

            });


            function createColorPickAction() {
                var colorPickerCallback = editor.settings.color_picker_callback;

                if (colorPickerCallback) {
                    return function() {
                        var self = this;

                        colorPickerCallback.call(
                            editor,
                            function(value) {
                                self.value(value).fire('change');
                            },
                            self.value()
                        );
                    };
                }
            }

        },

        getInfo : function() {
            return {
                longname : "Link button",
                author : "Pressfoundry",
                version : "1"
            };
        }
    });


    tinymce.PluginManager.add("btn_link", tinymce.plugins.btn_link);


})(jQuery, tinymce);