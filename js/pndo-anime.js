/**
 * Created by Thibaut on 13/06/2018.
 */
var PndoAnime = /** @class */ (function () {
    function PndoAnime(_defaultOffset, _target) {
        this.defaultOffset = 0.95;
        this.init = false;
        this.ticking = false;
        this.namespace = "pando-anime-";
        this.target = _target;
        if (this.defaultOffset != null && this.defaultOffset != undefined)
            this.defaultOffset = 0.9;
        else
            this.defaultOffset = _defaultOffset;
        if (_target == undefined) {
            this.target = window;
        }
        this.workspaceWidth = this.target.innerWidth;
        this.workspaceHeight = this.target.innerHeight;
        this.animatedElements = document.querySelectorAll(".motion");
        this.autoActiveElements = document.querySelectorAll(".autoActive");
        this.parallaxedElements = document.querySelectorAll(".parallaxed");
        this.listeners = {};
        this.dispatchScroll = this.dispatchScroll.bind(this);
        this.scrollingMotion = this.scrollingMotion.bind(this);
        this.checkResize = this.checkResize.bind(this);
        this.checkEvent = this.checkEvent.bind(this);
        this.on = this.on.bind(this);
        if (this.init) {
            this.scrollingMotion();
        }
        this.target.addEventListener('scroll', this.scrollingMotion);
        this.target.addEventListener('resize', this.checkResize);
    }
    PndoAnime.prototype.checkResize = function () {
        this.workspaceHeight = window.innerHeight;
        this.workspaceWidth = window.innerWidth;
        this.scrollingMotion();
    };
    PndoAnime.prototype.scrollingMotion = function () {
        this.ticking = false;
        if (!this.ticking) {
            this.dispatchScroll();
            this.scrollTop = window.pageYOffset;
            console.log("scrolling scrollTop : " + this.scrollTop);
            var _loop_1 = function () {
                el = this_1.animatedElements[i];
                elemRect = el.getBoundingClientRect();
                offset = this_1.defaultOffset;
                if (el.hasAttribute("offset")) {
                    offset = parseInt(el.getAttribute("offset"));
                }
                if (elemRect.top - (this_1.workspaceHeight * offset) < 0) {
                    if (el.hasAttribute("delay")) {
                        var delay = parseInt(el.getAttribute("delay"));
                        var item_1 = el;
                        setTimeout(function () {
                            item_1.classList.add('motion-animated');
                        }, delay);
                    }
                    else {
                        el.classList.add('motion-animated');
                    }
                }
                else {
                    if (!el.classList.contains("stay-active"))
                        el.classList.remove('motion-animated');
                }
            };
            var this_1 = this, el, elemRect, offset;
            for (var i = 0; i < this.animatedElements.length; i++) {
                _loop_1();
            }
            ;
            for (var i = 0; i < this.parallaxedElements.length; i++) {
                var el = this.parallaxedElements[i];
                var elemRect = el.getBoundingClientRect();
                var state = elemRect.top - this.workspaceHeight;
                if (state < 0 && state > -this.workspaceHeight) {
                    var intermediate_state = this.workspaceHeight;
                    var percent_b_p = (-state / intermediate_state) * 100;
                    if (i == 0)
                        console.log("percent_b_p = " + percent_b_p);
                    el.style.transform = "translateY(" + (state / 6) + "px)";
                }
                else {
                    el.classList.remove('motion-animate');
                }
            }
            ;
            if (this.workspaceWidth < 780) {
                for (var i = 0; i < this.autoActiveElements.length; i++) {
                    var el = this.autoActiveElements[i];
                    var elemRect = el.getBoundingClientRect();
                    if (elemRect.top - (this.workspaceHeight * 0.5) < 0 && elemRect.bottom - (this.workspaceHeight * 0.5) > 0) {
                        el.classList.add('active');
                    }
                    else {
                        el.classList.remove('active');
                    }
                }
                ;
            }
            this.ticking = false;
        }
        this.ticking = true;
    };
    PndoAnime.prototype.on = function (event, func) {
        this.setEvents(event, func);
    };
    PndoAnime.prototype.setEvents = function (event, func) {
        if (!this.listeners[event]) {
            this.listeners[event] = [];
        }
        var list = this.listeners[event];
        list.push(func);
        if (list.length === 1) {
            this.target.addEventListener(this.namespace + event, this.checkEvent, false);
        }
    };
    PndoAnime.prototype.unsetEvents = function (event, func) {
        if (!this.listeners[event])
            return;
        var list = this.listeners[event];
        var index = list.indexOf(func);
        if (index < 0)
            return;
        list.splice(index, 1);
        if (list.index === 0) {
            this.target.removeEventListener(this.namespace + event, this.checkEvent, false);
        }
    };
    PndoAnime.prototype.checkEvent = function (event) {
        var name = event.type.replace(this.namespace, '');
        var list = this.listeners[name];
        if (!list || list.length === 0)
            return;
        list.forEach(function (func) {
            return func();
        });
    };
    PndoAnime.prototype.dispatchScroll = function () {
        var scrollEvent = new Event(this.namespace + 'scroll');
        this.target.dispatchEvent(scrollEvent);
    };
    PndoAnime.prototype.destroy = function () {
        var _this = this;
        this.target.removeEventListener('resize', this.checkResize, false);
        this.target.removeEventListener('scroll', this.scrollingMotion, false);
        Object.keys(this.listeners).forEach(function (event) {
            _this.target.removeEventListener(_this.namespace + event, _this.checkEvent, false);
        });
        this.listeners = {};
    };
    return PndoAnime;
}());
