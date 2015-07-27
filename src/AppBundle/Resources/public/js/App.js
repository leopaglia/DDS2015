function App() {} //Requires JQuery

App.prototype = {

    root: null,

    //magic number las pelotas, es un array de config
    //chupame un huevo jslint
    config: {

        icons:{
            height : 24,
            width  : 24,
            border: 0
        },

        blockUI:{
            border: 'none',
            padding: '15px',
            backgroundColor: '#001',
            webkitBorderRadius: '10px',
            mozBorderRadius: '10px',
            opacity: 0.5,
            color: '#fff'
        }

    },

    //constantes icons
    icons: {
        ADD: "add",
        DELETE: "delete",
        EDIT: "edit",
        DETAIL: "detail"
    },

    init: function (root) {
        this.root = root;
    },

    showLoading: function (message) {

        var config = this.config.blockUI;

        $.blockUI({
            css: {
                border: config.border,
                padding: config.padding,
                backgroundColor: config.backgroundColor,
                '-webkit-border-radius': config.webkitBorderRadius,
                '-moz-border-radius': config.mozBorderRadius,
                opacity: config.opacity,
                color: config.color
            },
            message: '<h3>' + message + '</h3>'
        });
    },

    hideLoading: function () {
        $.unblockUI();
    },

    //SEGURO que hay una mejor forma de direccionar las imagenes
    createIcon : function (name, title) {

        var config = this.config.icons;

        var img = new Image();

        if (name === this.icons.ADD) {
            img.src = this.root + "bundles/app/img/add.png";
        }

        img.alt = title;
        img.title = title;
        img.width = config.width;
        img.height = config.height;
        img.border = config.border;
        img.className = name + ' zoomIt';

        return img.outerHTML;
    }

}