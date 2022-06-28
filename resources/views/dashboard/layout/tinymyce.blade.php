<script src="{{ asset('assets/tinymce/jquery.tinymce.min.js') }}"></script>

<script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
<script>
    var editor_config = {
        path_absolute : "{{ URL::to('/') }}/",
        selector: "textarea.myfield",
        plugins: [
            "advlist autolink lists link image charmap print hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen fullpage",
            "insertdatetime media nonbreaking save table textcolor contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],

        style_formats: [
            {title: 'Image Left', selector: 'img', styles: {
                'float' : 'left',
                'margin': '0 20px 0 10px'
            }},
            {title: 'Image Right', selector: 'img', styles: {
                'float' : 'right',
                'margin': '0 10px 0 20px'
            }}
        ],
        style_formats_merge: true,



        toolbar: "insertfile undo redo| styleselect | bold italic | alignleft aligncenter alignright alignjustify" +
        " | forecolor backcolor | bullist numlist outdent indent | link image media | fontsizeselect ",
        relative_urls: false,
        file_browser_callback : function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if(type == 'image'){
                cmsURL = cmsURL + "&type=Images";
            }else{
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        },
        entity_encoding : "numeric",

//        extended_valid_elements : "html,style,link[href|rel]",
//        custom_elements:"style,link,~link",
//        extended_valid_elements : "div[*],meta[*],span[*],html[*]",
//        valid_children : "+body[meta],+div[html|h2|span|meta|object],+object[param|embed]",

    };
    tinymce.init(editor_config);
</script>