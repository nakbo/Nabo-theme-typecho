window.kat = {};
window.kat.register = function () {
    for (let i = 0; i < arguments.length; i += 2) {
        window.kat[arguments[i]] = arguments[i + 1];
    }
}
window.function = {};
window.function.register = function (func, name, execute = true) {
    window.function[name] = func;
    if (execute) {
        func();
    }
}
window.function.execute = function () {
    for (let i = 0; i < arguments.length; i++) {
        window.function[arguments[i]]();
    }
}

window.function.targetAll = function () {
    $(".comment-list a").attr("target", "_blank");
    $(".markdown-body a").attr("target", "_blank");
}

window.function.friends = function () {
    let friends_length = window.kat.friends == null ? 0 : window.kat.friends.length;
    let relations_length = window.kat.relations == null ? 0 : window.kat.relations.length;
    if (friends_length + relations_length) {
        $('.comment-author span img').each(function () {
            let match = false;
            let src = $(this).attr("src");
            if (friends_length) {
                for (let pos = 0; pos < friends_length; pos++) {
                    if (src.indexOf(window.kat.friends[pos]) !== -1) {
                        match = true;
                        $(this).parent().addClass("avatar-by-friend");
                    }
                }
            }
            if (relations_length && match === false) {
                for (let pos = 0; pos < relations_length; pos++) {
                    if (src.indexOf(window.kat.relations[pos]) !== -1) {
                        $(this).parent().addClass("avatar-by-relation");
                    }
                }
            }
        });
    }
}

window.function.image = function () {
    let able = false;
    $.each(['.markdown-body img', '.comment-content img'], function (i, key) {
        $(key).each(function () {
            if (able && $(this).attr("title") !== "" && $(this).attr("title") !== "请输入图片描述") {
                let setWith = this.width > 9 ? this.width + "px" : "100%";
                $(this).after("<p style='text-align:center;margin:5px 0 0 0;width:" + setWith + "'>" + $(this).attr("title") + "</p>")
            }
            $(this).wrap("<a class='gallery' data-fancybox='gallery' no-pjax data-type='image' data-caption='" +
                $(this).attr("title") + "' href='" +
                $(this).attr(able ? "src" : "data-src") + "'></a>");
        });
        able = true;
    });
    $('.markdown-body p').each(function () {
        let images = $(this).find('a.gallery');
        if (images.length >= window.kat.gallery.valve) {
            $(this).addClass('galleries');
            $(this).addClass('gallery-' + (images.length > 4 ? 3 : images.length));
        }
    });

    // lazy
    lazyload();
}

window.function.katex = function () {
    renderMathInElement(document.body, {
        delimiters: [{
            left: "$$", right: "$$", display: true
        }, {
            left: "$", right: "$", display: false
        }],
        ignoredTags: ["script", "noscript", "style", "textarea", "pre", "code"],
        ignoredClasses: ["nokatex"]
    });
}

window.function.OwO = function () {
    let box = document.getElementById('OwO');
    if (box != null) {
        new OwO({
            logo: 'OωO',
            container: box,
            target: document.getElementById('textarea'),
            api: window.kat.options.themeUrl + 'assets/OwO.json',
            position: 'down',
            width: '100%',
            maxHeight: '250px'
        });
    }
}

window.function.highlight = function (reload = false) {
    if (reload) {
        document.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    } else {
        hljs.initHighlightingOnLoad();
    }
}

window.function.navigator = function (pjax = false) {
    let menu = window.kat.menu;
    if (pjax && !menu.eject) {
        return;
    }
    if (menu.eject) {
        window.kat.nabo.removeClass("fixed")
        menu.navigator.removeClass("fixed");
    } else {
        window.kat.nabo.addClass("fixed")
        menu.navigator.addClass("fixed");
    }
    menu.eject = !menu.eject;
}

window.function.footer = function () {
    window.kat.nabo = $("#nabo");
    window.kat.menu = {
        navigator: $(".navigator"), eject: false,
        layer: $('<div class="layer" onclick="window.function.navigator()"></div>')
    }
    window.kat.menu.layer.prependTo(
        window.kat.nabo
    );

    $(document).pjax(
        'a[href^="' + window.kat.options.siteUrl + '"]:not(a[target="_blank"], a[no-pjax])', {
            container: "#nabo",
            fragment: "#nabo",
            timeout: 8000
        }
    ).on('pjax:send',
        function () {
            NProgress.start();
        }).on('pjax:complete', function () {
        NProgress.done();
        window.kat.nabo.animate({
            scrollTop: '0px'
        }, 700);

        // navigator
        window.function.navigator(true);

        // highlight
        window.function.highlight(true);

        // targetAll image owo katex
        window.function.execute(
            'image', 'targetAll', 'friends', 'OwO', 'katex'
        );
    });
}

window.function.commentPjax = function (respondId, token) {
    let respond = document.getElementById(
        respondId
    );

    if (respond != null) {
        let forms = respond.getElementsByTagName('form');
        if (forms.length) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_';
            input.value = token;
            forms[0].appendChild(input);
        }
    }

    window.TypechoComment = {
        dom: function (id) {
            return document.getElementById(id);
        },
        create: function (tag, attr) {
            let el = document.createElement(tag);
            for (let key in attr) {
                el.setAttribute(key, attr[key]);
            }
            return el;
        },

        reply: function (cid, coid) {
            let comment = this.dom(cid),
                response = this.dom(respondId), input = this.dom('comment-parent'),
                form = 'form' === response.tagName ? response : response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];

            if (null == input) {
                input = this.create('input', {
                    'type': 'hidden',
                    'name': 'parent',
                    'id': 'comment-parent'
                });
                form.appendChild(input);
            }

            input.setAttribute('value', coid);

            if (null == this.dom('comment-form-place-holder')) {
                let holder = this.create('div', {
                    'id': 'comment-form-place-holder'
                });
                response.parentNode.insertBefore(holder, response);
            }

            comment.appendChild(response);
            this.dom('cancel-comment-reply-link').style.display = '';

            if (null != textarea && 'text' === textarea.name) {
                textarea.focus();
            }
            return false;
        },

        cancelReply: function () {
            let response = this.dom(respondId),
                holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');

            if (null != input) {
                input.parentNode.removeChild(input);
            }
            if (null == holder) {
                return true;
            }

            this.dom('cancel-comment-reply-link').style.display = 'none';
            holder.parentNode.insertBefore(response, holder);
            return false;
        }
    };
};