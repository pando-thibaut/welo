/**
 * Created by Thibaut on 13/06/2018.
 */
class PndoAnime {
    defaultOffset: number = 0.95;
    target: any;
    init: boolean = false;
    animatedElements: any;
    autoActiveElements: any;
    parallaxedElements: any;
    scrollTop : number;
    ticking : boolean = false;
    workspaceHeight : any;
    workspaceWidth : any;
    listeners : any;
    namespace : string = "pando-anime-"
    constructor(
        _defaultOffset: number,
        _target?: any,
    ) {

        this.target = _target;

        if(this.defaultOffset != null && this.defaultOffset != undefined)
            this.defaultOffset = 0.9;
        else
            this.defaultOffset = _defaultOffset;


        if(_target == undefined)
        {
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

        if(this.init) {
            this.scrollingMotion();
        }

        this.target.addEventListener('scroll', this.scrollingMotion);
        this.target.addEventListener('resize', this.checkResize);
    }

    checkResize(): void
    {
        this.workspaceHeight = window.innerHeight;
        this.workspaceWidth = window.innerWidth;
        this.scrollingMotion();
    }


    scrollingMotion(): void {

        this.ticking = false;

        if (!this.ticking) {

            this.dispatchScroll();

            this.scrollTop = window.pageYOffset;
            console.log("scrolling scrollTop : "+this.scrollTop);
            for (var i = 0; i < this.animatedElements.length; i++) {

                var el = this.animatedElements[i];
                var elemRect = el.getBoundingClientRect();
                var offset = this.defaultOffset;

                if (el.hasAttribute("offset")) {
                    offset = parseInt(el.getAttribute("offset"));
                }

                if (elemRect.top - (this.workspaceHeight * offset) < 0) {
                    if (el.hasAttribute("delay")) {
                        let delay = parseInt(el.getAttribute("delay"));
                        let item = el;
                        setTimeout(function () {
                            item.classList.add('motion-animated');
                        }, delay);
                    }
                    else {
                        el.classList.add('motion-animated');
                    }
                } else {
                    if (!el.classList.contains("stay-active"))
                        el.classList.remove('motion-animated');
                }
            };

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
                } else {
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
                    } else {
                        el.classList.remove('active');
                    }
                }
                ;
            }
            this.ticking = false;
        }
        this.ticking = true;
    }

    on(event, func): void
    {
        this.setEvents(event, func);
    }

    setEvents(event, func): void {
        if (!this.listeners[event]) {
            this.listeners[event] = [];
        }

        const list = this.listeners[event];
        list.push(func);

        if (list.length === 1) {
            this.target.addEventListener(this.namespace + event, this.checkEvent, false);
        }
    }

    unsetEvents(event, func): void {
        if (!this.listeners[event]) return;

        const list = this.listeners[event];
        const index = list.indexOf(func);

        if (index < 0) return;

        list.splice(index, 1);

        if (list.index === 0) {
            this.target.removeEventListener(this.namespace + event, this.checkEvent, false);
        }
    }

    checkEvent(event): any {
        const name = event.type.replace(this.namespace, '');
        const list = this.listeners[name];

        if (!list || list.length === 0) return;

        list.forEach((func) => {
            return func();
        });
    }

    dispatchScroll(): void {
        const scrollEvent = new Event(this.namespace + 'scroll');
        this.target.dispatchEvent(scrollEvent);
    }

    destroy(): void {
        this.target.removeEventListener('resize', this.checkResize, false);
        this.target.removeEventListener('scroll', this.scrollingMotion, false);
        Object.keys(this.listeners).forEach((event) => {
            this.target.removeEventListener(this.namespace + event, this.checkEvent, false);
        });
        this.listeners = {};
    }

}