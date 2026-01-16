/*! For license information please see main.js.LICENSE.txt */
(() => {
    'use strict';
    var e = {
            72: (e, t, n) => {
                var r,
                    o = (function () {
                        var e = {};
                        return function (t) {
                            if (void 0 === e[t]) {
                                var n = document.querySelector(t);
                                if (window.HTMLIFrameElement && n instanceof window.HTMLIFrameElement)
                                    try {
                                        n = n.contentDocument.head;
                                    } catch (e) {
                                        n = null;
                                    }
                                e[t] = n;
                            }
                            return e[t];
                        };
                    })(),
                    i = [];
                function s(e) {
                    for (var t = -1, n = 0; n < i.length; n++)
                        if (i[n].identifier === e) {
                            t = n;
                            break;
                        }
                    return t;
                }
                function a(e, t) {
                    for (var n = {}, r = [], o = 0; o < e.length; o++) {
                        var a = e[o],
                            l = t.base ? a[0] + t.base : a[0],
                            c = n[l] || 0,
                            d = ''.concat(l, ' ').concat(c);
                        n[l] = c + 1;
                        var u = s(d),
                            p = { css: a[1], media: a[2], sourceMap: a[3] };
                        (-1 !== u
                            ? (i[u].references++, i[u].updater(p))
                            : i.push({ identifier: d, updater: m(p, t), references: 1 }),
                            r.push(d));
                    }
                    return r;
                }
                function l(e) {
                    var t = document.createElement('style'),
                        r = e.attributes || {};
                    if (void 0 === r.nonce) {
                        var i = n.nc;
                        i && (r.nonce = i);
                    }
                    if (
                        (Object.keys(r).forEach(function (e) {
                            t.setAttribute(e, r[e]);
                        }),
                        'function' == typeof e.insert)
                    )
                        e.insert(t);
                    else {
                        var s = o(e.insert || 'head');
                        if (!s)
                            throw new Error(
                                "Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid."
                            );
                        s.appendChild(t);
                    }
                    return t;
                }
                var c,
                    d =
                        ((c = []),
                        function (e, t) {
                            return ((c[e] = t), c.filter(Boolean).join('\n'));
                        });
                function u(e, t, n, r) {
                    var o = n ? '' : r.media ? '@media '.concat(r.media, ' {').concat(r.css, '}') : r.css;
                    if (e.styleSheet) e.styleSheet.cssText = d(t, o);
                    else {
                        var i = document.createTextNode(o),
                            s = e.childNodes;
                        (s[t] && e.removeChild(s[t]), s.length ? e.insertBefore(i, s[t]) : e.appendChild(i));
                    }
                }
                function p(e, t, n) {
                    var r = n.css,
                        o = n.media,
                        i = n.sourceMap;
                    if (
                        (o ? e.setAttribute('media', o) : e.removeAttribute('media'),
                        i &&
                            'undefined' != typeof btoa &&
                            (r += '\n/*# sourceMappingURL=data:application/json;base64,'.concat(
                                btoa(unescape(encodeURIComponent(JSON.stringify(i)))),
                                ' */'
                            )),
                        e.styleSheet)
                    )
                        e.styleSheet.cssText = r;
                    else {
                        for (; e.firstChild; ) e.removeChild(e.firstChild);
                        e.appendChild(document.createTextNode(r));
                    }
                }
                var f = null,
                    h = 0;
                function m(e, t) {
                    var n, r, o;
                    if (t.singleton) {
                        var i = h++;
                        ((n = f || (f = l(t))), (r = u.bind(null, n, i, !1)), (o = u.bind(null, n, i, !0)));
                    } else
                        ((n = l(t)),
                            (r = p.bind(null, n, t)),
                            (o = function () {
                                !(function (e) {
                                    if (null === e.parentNode) return !1;
                                    e.parentNode.removeChild(e);
                                })(n);
                            }));
                    return (
                        r(e),
                        function (t) {
                            if (t) {
                                if (t.css === e.css && t.media === e.media && t.sourceMap === e.sourceMap) return;
                                r((e = t));
                            } else o();
                        }
                    );
                }
                e.exports = function (e, t) {
                    (t = t || {}).singleton ||
                        'boolean' == typeof t.singleton ||
                        (t.singleton =
                            (void 0 === r && (r = Boolean(window && document && document.all && !window.atob)), r));
                    var n = a((e = e || []), t);
                    return function (e) {
                        if (((e = e || []), '[object Array]' === Object.prototype.toString.call(e))) {
                            for (var r = 0; r < n.length; r++) {
                                var o = s(n[r]);
                                i[o].references--;
                            }
                            for (var l = a(e, t), c = 0; c < n.length; c++) {
                                var d = s(n[c]);
                                0 === i[d].references && (i[d].updater(), i.splice(d, 1));
                            }
                            n = l;
                        }
                    };
                };
            },
            84: (e, t, n) => {
                n.d(t, { A: () => i });
                var r = n(798),
                    o = n.n(r)()(function (e) {
                        return e[1];
                    });
                o.push([
                    e.id,
                    "/**\n * Swiper 12.0.3\n * Most modern mobile touch slider and framework with hardware accelerated transitions\n * https://swiperjs.com\n *\n * Copyright 2014-2025 Vladimir Kharlampidi\n *\n * Released under the MIT License\n *\n * Released on: October 21, 2025\n */\n\n:root {\n  --swiper-theme-color: #007aff;\n  /*\n  --swiper-preloader-color: var(--swiper-theme-color);\n  --swiper-wrapper-transition-timing-function: initial;\n  */\n}\n:host {\n  position: relative;\n  display: block;\n  margin-left: auto;\n  margin-right: auto;\n  z-index: 1;\n}\n.swiper {\n  margin-left: auto;\n  margin-right: auto;\n  position: relative;\n  overflow: hidden;\n  list-style: none;\n  padding: 0;\n  /* Fix of Webkit flickering */\n  z-index: 1;\n  display: block;\n}\n.swiper-vertical > .swiper-wrapper {\n  flex-direction: column;\n}\n.swiper-wrapper {\n  position: relative;\n  width: 100%;\n  height: 100%;\n  z-index: 1;\n  display: flex;\n  transition-property: transform;\n  transition-timing-function: var(--swiper-wrapper-transition-timing-function, initial);\n  box-sizing: content-box;\n}\n.swiper-android .swiper-slide,\n.swiper-ios .swiper-slide,\n.swiper-wrapper {\n  transform: translate3d(0px, 0, 0);\n}\n.swiper-horizontal {\n  touch-action: pan-y;\n}\n.swiper-vertical {\n  touch-action: pan-x;\n}\n.swiper-slide {\n  flex-shrink: 0;\n  width: 100%;\n  height: 100%;\n  position: relative;\n  transition-property: transform;\n  display: block;\n}\n.swiper-slide-invisible-blank {\n  visibility: hidden;\n}\n/* Auto Height */\n.swiper-autoheight,\n.swiper-autoheight .swiper-slide {\n  height: auto;\n}\n.swiper-autoheight .swiper-wrapper {\n  align-items: flex-start;\n  transition-property: transform, height;\n}\n.swiper-backface-hidden .swiper-slide {\n  transform: translateZ(0);\n  backface-visibility: hidden;\n}\n/* 3D Effects */\n.swiper-3d.swiper-css-mode .swiper-wrapper {\n  perspective: 1200px;\n}\n.swiper-3d .swiper-wrapper {\n  transform-style: preserve-3d;\n}\n.swiper-3d {\n  perspective: 1200px;\n  .swiper-slide,\n  .swiper-cube-shadow {\n    transform-style: preserve-3d;\n  }\n}\n\n/* CSS Mode */\n.swiper-css-mode {\n  > .swiper-wrapper {\n    overflow: auto;\n    scrollbar-width: none; /* For Firefox */\n    -ms-overflow-style: none; /* For Internet Explorer and Edge */\n    &::-webkit-scrollbar {\n      display: none;\n    }\n  }\n  > .swiper-wrapper > .swiper-slide {\n    scroll-snap-align: start start;\n  }\n  &.swiper-horizontal {\n    > .swiper-wrapper {\n      scroll-snap-type: x mandatory;\n    }\n  }\n  &.swiper-vertical {\n    > .swiper-wrapper {\n      scroll-snap-type: y mandatory;\n    }\n  }\n  &.swiper-free-mode {\n    > .swiper-wrapper {\n      scroll-snap-type: none;\n    }\n    > .swiper-wrapper > .swiper-slide {\n      scroll-snap-align: none;\n    }\n  }\n  &.swiper-centered {\n    > .swiper-wrapper::before {\n      content: '';\n      flex-shrink: 0;\n      order: 9999;\n    }\n    > .swiper-wrapper > .swiper-slide {\n      scroll-snap-align: center center;\n      scroll-snap-stop: always;\n    }\n  }\n  &.swiper-centered.swiper-horizontal {\n    > .swiper-wrapper > .swiper-slide:first-child {\n      margin-inline-start: var(--swiper-centered-offset-before);\n    }\n    > .swiper-wrapper::before {\n      height: 100%;\n      min-height: 1px;\n      width: var(--swiper-centered-offset-after);\n    }\n  }\n  &.swiper-centered.swiper-vertical {\n    > .swiper-wrapper > .swiper-slide:first-child {\n      margin-block-start: var(--swiper-centered-offset-before);\n    }\n    > .swiper-wrapper::before {\n      width: 100%;\n      min-width: 1px;\n      height: var(--swiper-centered-offset-after);\n    }\n  }\n}\n\n/* Slide styles start */\n/* 3D Shadows */\n.swiper-3d {\n  .swiper-slide-shadow,\n  .swiper-slide-shadow-left,\n  .swiper-slide-shadow-right,\n  .swiper-slide-shadow-top,\n  .swiper-slide-shadow-bottom,\n  .swiper-slide-shadow,\n  .swiper-slide-shadow-left,\n  .swiper-slide-shadow-right,\n  .swiper-slide-shadow-top,\n  .swiper-slide-shadow-bottom {\n    position: absolute;\n    left: 0;\n    top: 0;\n    width: 100%;\n    height: 100%;\n    pointer-events: none;\n    z-index: 10;\n  }\n  .swiper-slide-shadow {\n    background: rgba(0, 0, 0, 0.15);\n  }\n  .swiper-slide-shadow-left {\n    background-image: linear-gradient(to left, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));\n  }\n  .swiper-slide-shadow-right {\n    background-image: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));\n  }\n  .swiper-slide-shadow-top {\n    background-image: linear-gradient(to top, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));\n  }\n  .swiper-slide-shadow-bottom {\n    background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));\n  }\n}\n.swiper-lazy-preloader {\n  width: 42px;\n  height: 42px;\n  position: absolute;\n  left: 50%;\n  top: 50%;\n  margin-left: -21px;\n  margin-top: -21px;\n  z-index: 10;\n  transform-origin: 50%;\n  box-sizing: border-box;\n  border: 4px solid var(--swiper-preloader-color, var(--swiper-theme-color));\n  border-radius: 50%;\n  border-top-color: transparent;\n}\n.swiper:not(.swiper-watch-progress),\n.swiper-watch-progress .swiper-slide-visible {\n  .swiper-lazy-preloader {\n    animation: swiper-preloader-spin 1s infinite linear;\n  }\n}\n.swiper-lazy-preloader-white {\n  --swiper-preloader-color: #fff;\n}\n.swiper-lazy-preloader-black {\n  --swiper-preloader-color: #000;\n}\n@keyframes swiper-preloader-spin {\n  0% {\n    transform: rotate(0deg);\n  }\n  100% {\n    transform: rotate(360deg);\n  }\n}\n/* Slide styles end */\n",
                    ''
                ]);
                const i = o;
            },
            798: e => {
                e.exports = function (e) {
                    var t = [];
                    return (
                        (t.toString = function () {
                            return this.map(function (t) {
                                var n = e(t);
                                return t[2] ? '@media '.concat(t[2], ' {').concat(n, '}') : n;
                            }).join('');
                        }),
                        (t.i = function (e, n, r) {
                            'string' == typeof e && (e = [[null, e, '']]);
                            var o = {};
                            if (r)
                                for (var i = 0; i < this.length; i++) {
                                    var s = this[i][0];
                                    null != s && (o[s] = !0);
                                }
                            for (var a = 0; a < e.length; a++) {
                                var l = [].concat(e[a]);
                                (r && o[l[0]]) ||
                                    (n && (l[2] ? (l[2] = ''.concat(n, ' and ').concat(l[2])) : (l[2] = n)), t.push(l));
                            }
                        }),
                        t
                    );
                };
            }
        },
        t = {};
    function n(r) {
        var o = t[r];
        if (void 0 !== o) return o.exports;
        var i = (t[r] = { id: r, exports: {} });
        return (e[r](i, i.exports, n), i.exports);
    }
    ((n.n = e => {
        var t = e && e.__esModule ? () => e.default : () => e;
        return (n.d(t, { a: t }), t);
    }),
        (n.d = (e, t) => {
            for (var r in t) n.o(t, r) && !n.o(e, r) && Object.defineProperty(e, r, { enumerable: !0, get: t[r] });
        }),
        (n.g = (function () {
            if ('object' == typeof globalThis) return globalThis;
            try {
                return this || new Function('return this')();
            } catch (e) {
                if ('object' == typeof window) return window;
            }
        })()),
        (n.o = (e, t) => Object.prototype.hasOwnProperty.call(e, t)),
        (n.r = e => {
            ('undefined' != typeof Symbol &&
                Symbol.toStringTag &&
                Object.defineProperty(e, Symbol.toStringTag, { value: 'Module' }),
                Object.defineProperty(e, '__esModule', { value: !0 }));
        }),
        (n.nc = void 0));
    var r = {};
    function o(e) {
        const t = Object.create(null);
        for (const n of e.split(',')) t[n] = 1;
        return e => e in t;
    }
    (n.r(r),
        n.d(r, {
            BaseTransition: () => Yr,
            BaseTransitionPropsValidators: () => qr,
            Comment: () => ga,
            DeprecationTypes: () => Nl,
            EffectScope: () => _e,
            ErrorCodes: () => Mn,
            ErrorTypeStrings: () => El,
            Fragment: () => ha,
            KeepAlive: () => Po,
            ReactiveEffect: () => Ae,
            Static: () => va,
            Suspense: () => aa,
            Teleport: () => Fr,
            Text: () => ma,
            TrackOpTypes: () => mn,
            Transition: () => ql,
            TransitionGroup: () => Hc,
            TriggerOpTypes: () => gn,
            VueElement: () => Rc,
            assertNumber: () => In,
            callWithAsyncErrorHandling: () => Ln,
            callWithErrorHandling: () => Nn,
            camelize: () => N,
            capitalize: () => $,
            cloneVNode: () => $a,
            compatUtils: () => Pl,
            computed: () => wl,
            createApp: () => Sd,
            createBlock: () => Ea,
            createCommentVNode: () => ja,
            createElementBlock: () => ka,
            createElementVNode: () => Na,
            createHydrationRenderer: () => Js,
            createPropsRestProxy: () => Mi,
            createRenderer: () => Xs,
            createSSRApp: () => xd,
            createSlots: () => ai,
            createStaticVNode: () => Da,
            createTextVNode: () => Fa,
            createVNode: () => La,
            customRef: () => ln,
            defineAsyncComponent: () => Oo,
            defineComponent: () => to,
            defineCustomElement: () => Pc,
            defineEmits: () => bi,
            defineExpose: () => wi,
            defineModel: () => _i,
            defineOptions: () => Si,
            defineProps: () => yi,
            defineSSRCustomElement: () => Nc,
            defineSlots: () => xi,
            devtools: () => Al,
            effect: () => Ve,
            effectScope: () => Te,
            getCurrentInstance: () => Xa,
            getCurrentScope: () => Ce,
            getCurrentWatcher: () => wn,
            getTransitionRawChildren: () => eo,
            guardReactiveProps: () => Ra,
            h: () => Sl,
            handleError: () => Rn,
            hasInjectionContext: () => Xi,
            hydrate: () => wd,
            hydrateOnIdle: () => To,
            hydrateOnInteraction: () => Eo,
            hydrateOnMediaQuery: () => ko,
            hydrateOnVisible: () => Co,
            initCustomFormatter: () => xl,
            initDirectivesForSSR: () => Ad,
            inject: () => Ki,
            isMemoSame: () => Tl,
            isProxy: () => qt,
            isReactive: () => zt,
            isReadonly: () => Ht,
            isRef: () => Xt,
            isRuntimeOnly: () => dl,
            isShallow: () => Ut,
            isVNode: () => Aa,
            markRaw: () => Gt,
            mergeDefaults: () => Oi,
            mergeModels: () => Ii,
            mergeProps: () => Ua,
            nextTick: () => Un,
            nodeOps: () => Dl,
            normalizeClass: () => Z,
            normalizeProps: () => ee,
            normalizeStyle: () => Y,
            onActivated: () => Lo,
            onBeforeMount: () => zo,
            onBeforeUnmount: () => Wo,
            onBeforeUpdate: () => Uo,
            onDeactivated: () => Ro,
            onErrorCaptured: () => Jo,
            onMounted: () => Ho,
            onRenderTracked: () => Xo,
            onRenderTriggered: () => Ko,
            onScopeDispose: () => ke,
            onServerPrefetch: () => Yo,
            onUnmounted: () => Go,
            onUpdated: () => qo,
            onWatcherCleanup: () => Sn,
            openBlock: () => wa,
            patchProp: () => Ic,
            popScopeId: () => _r,
            provide: () => Yi,
            proxyRefs: () => sn,
            pushScopeId: () => xr,
            queuePostFlushCb: () => Gn,
            reactive: () => Bt,
            readonly: () => Dt,
            ref: () => Jt,
            registerRuntimeCompiler: () => cl,
            render: () => bd,
            renderList: () => si,
            renderSlot: () => li,
            resolveComponent: () => ei,
            resolveDirective: () => ri,
            resolveDynamicComponent: () => ni,
            resolveFilter: () => Ml,
            resolveTransitionHooks: () => Xr,
            setBlockTracking: () => Ta,
            setDevtoolsHook: () => Ol,
            setTransitionHooks: () => Zr,
            shallowReactive: () => Ft,
            shallowReadonly: () => jt,
            shallowRef: () => Qt,
            ssrContextKey: () => Ji,
            ssrUtils: () => Il,
            stop: () => ze,
            toDisplayString: () => ge,
            toHandlerKey: () => B,
            toHandlers: () => di,
            toRaw: () => Wt,
            toRef: () => pn,
            toRefs: () => cn,
            toValue: () => rn,
            transformVNodeArgs: () => Ia,
            triggerRef: () => tn,
            unref: () => nn,
            useAttrs: () => ki,
            useCssModule: () => Fc,
            useCssVars: () => dc,
            useHost: () => $c,
            useId: () => no,
            useModel: () => ss,
            useSSRContext: () => Qi,
            useShadowRoot: () => Bc,
            useSlots: () => Ci,
            useTemplateRef: () => io,
            useTransitionState: () => Hr,
            vModelCheckbox: () => Zc,
            vModelDynamic: () => sd,
            vModelRadio: () => td,
            vModelSelect: () => nd,
            vModelText: () => Qc,
            vShow: () => ac,
            version: () => Cl,
            warn: () => kl,
            watch: () => ns,
            watchEffect: () => Zi,
            watchPostEffect: () => es,
            watchSyncEffect: () => ts,
            withAsyncContext: () => Pi,
            withCtx: () => Cr,
            withDefaults: () => Ti,
            withDirectives: () => Er,
            withKeys: () => fd,
            withMemo: () => _l,
            withModifiers: () => ud,
            withScopeId: () => Tr
        }));
    const i = Object.freeze({}),
        s = Object.freeze([]),
        a = () => {},
        l = () => !1,
        c = e => 111 === e.charCodeAt(0) && 110 === e.charCodeAt(1) && (e.charCodeAt(2) > 122 || e.charCodeAt(2) < 97),
        d = e => e.startsWith('onUpdate:'),
        u = Object.assign,
        p = (e, t) => {
            const n = e.indexOf(t);
            n > -1 && e.splice(n, 1);
        },
        f = Object.prototype.hasOwnProperty,
        h = (e, t) => f.call(e, t),
        m = Array.isArray,
        g = e => '[object Map]' === C(e),
        v = e => '[object Set]' === C(e),
        y = e => '[object Date]' === C(e),
        b = e => 'function' == typeof e,
        w = e => 'string' == typeof e,
        S = e => 'symbol' == typeof e,
        x = e => null !== e && 'object' == typeof e,
        _ = e => (x(e) || b(e)) && b(e.then) && b(e.catch),
        T = Object.prototype.toString,
        C = e => T.call(e),
        k = e => C(e).slice(8, -1),
        E = e => '[object Object]' === C(e),
        A = e => w(e) && 'NaN' !== e && '-' !== e[0] && '' + parseInt(e, 10) === e,
        O = o(
            ',key,ref,ref_for,ref_key,onVnodeBeforeMount,onVnodeMounted,onVnodeBeforeUpdate,onVnodeUpdated,onVnodeBeforeUnmount,onVnodeUnmounted'
        ),
        I = o('bind,cloak,else-if,else,for,html,if,model,on,once,pre,show,slot,text,memo'),
        M = e => {
            const t = Object.create(null);
            return n => t[n] || (t[n] = e(n));
        },
        P = /-\w/g,
        N = M(e => e.replace(P, e => e.slice(1).toUpperCase())),
        L = /\B([A-Z])/g,
        R = M(e => e.replace(L, '-$1').toLowerCase()),
        $ = M(e => e.charAt(0).toUpperCase() + e.slice(1)),
        B = M(e => (e ? `on${$(e)}` : '')),
        F = (e, t) => !Object.is(e, t),
        D = (e, ...t) => {
            for (let n = 0; n < e.length; n++) e[n](...t);
        },
        j = (e, t, n, r = !1) => {
            Object.defineProperty(e, t, { configurable: !0, enumerable: !1, writable: r, value: n });
        },
        V = e => {
            const t = parseFloat(e);
            return isNaN(t) ? e : t;
        },
        z = e => {
            const t = w(e) ? Number(e) : NaN;
            return isNaN(t) ? e : t;
        };
    let H;
    const U = () =>
            H ||
            (H =
                'undefined' != typeof globalThis
                    ? globalThis
                    : 'undefined' != typeof self
                      ? self
                      : 'undefined' != typeof window
                        ? window
                        : void 0 !== n.g
                          ? n.g
                          : {}),
        q = {
            1: 'TEXT',
            2: 'CLASS',
            4: 'STYLE',
            8: 'PROPS',
            16: 'FULL_PROPS',
            32: 'NEED_HYDRATION',
            64: 'STABLE_FRAGMENT',
            128: 'KEYED_FRAGMENT',
            256: 'UNKEYED_FRAGMENT',
            512: 'NEED_PATCH',
            1024: 'DYNAMIC_SLOTS',
            2048: 'DEV_ROOT_FRAGMENT',
            [-1]: 'CACHED',
            [-2]: 'BAIL'
        },
        W = { 1: 'STABLE', 2: 'DYNAMIC', 3: 'FORWARDED' },
        G = o(
            'Infinity,undefined,NaN,isFinite,isNaN,parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,BigInt,console,Error,Symbol'
        );
    function Y(e) {
        if (m(e)) {
            const t = {};
            for (let n = 0; n < e.length; n++) {
                const r = e[n],
                    o = w(r) ? Q(r) : Y(r);
                if (o) for (const e in o) t[e] = o[e];
            }
            return t;
        }
        if (w(e) || x(e)) return e;
    }
    const K = /;(?![^(]*\))/g,
        X = /:([^]+)/,
        J = /\/\*[^]*?\*\//g;
    function Q(e) {
        const t = {};
        return (
            e
                .replace(J, '')
                .split(K)
                .forEach(e => {
                    if (e) {
                        const n = e.split(X);
                        n.length > 1 && (t[n[0].trim()] = n[1].trim());
                    }
                }),
            t
        );
    }
    function Z(e) {
        let t = '';
        if (w(e)) t = e;
        else if (m(e))
            for (let n = 0; n < e.length; n++) {
                const r = Z(e[n]);
                r && (t += r + ' ');
            }
        else if (x(e)) for (const n in e) e[n] && (t += n + ' ');
        return t.trim();
    }
    function ee(e) {
        if (!e) return null;
        let { class: t, style: n } = e;
        return (t && !w(t) && (e.class = Z(t)), n && (e.style = Y(n)), e);
    }
    const te = o(
            'html,body,base,head,link,meta,style,title,address,article,aside,footer,header,hgroup,h1,h2,h3,h4,h5,h6,nav,section,div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,ruby,s,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,embed,object,param,source,canvas,script,noscript,del,ins,caption,col,colgroup,table,thead,tbody,td,th,tr,button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,output,progress,select,textarea,details,dialog,menu,summary,template,blockquote,iframe,tfoot'
        ),
        ne = o(
            'svg,animate,animateMotion,animateTransform,circle,clipPath,color-profile,defs,desc,discard,ellipse,feBlend,feColorMatrix,feComponentTransfer,feComposite,feConvolveMatrix,feDiffuseLighting,feDisplacementMap,feDistantLight,feDropShadow,feFlood,feFuncA,feFuncB,feFuncG,feFuncR,feGaussianBlur,feImage,feMerge,feMergeNode,feMorphology,feOffset,fePointLight,feSpecularLighting,feSpotLight,feTile,feTurbulence,filter,foreignObject,g,hatch,hatchpath,image,line,linearGradient,marker,mask,mesh,meshgradient,meshpatch,meshrow,metadata,mpath,path,pattern,polygon,polyline,radialGradient,rect,set,solidcolor,stop,switch,symbol,text,textPath,title,tspan,unknown,use,view'
        ),
        re = o(
            'annotation,annotation-xml,maction,maligngroup,malignmark,math,menclose,merror,mfenced,mfrac,mfraction,mglyph,mi,mlabeledtr,mlongdiv,mmultiscripts,mn,mo,mover,mpadded,mphantom,mprescripts,mroot,mrow,ms,mscarries,mscarry,msgroup,msline,mspace,msqrt,msrow,mstack,mstyle,msub,msubsup,msup,mtable,mtd,mtext,mtr,munder,munderover,none,semantics'
        ),
        oe = o('area,base,br,col,embed,hr,img,input,link,meta,param,source,track,wbr'),
        ie = 'itemscope,allowfullscreen,formnovalidate,ismap,nomodule,novalidate,readonly',
        se = o(ie),
        ae = o(
            ie +
                ',async,autofocus,autoplay,controls,default,defer,disabled,hidden,inert,loop,open,required,reversed,scoped,seamless,checked,muted,multiple,selected'
        );
    function le(e) {
        return !!e || '' === e;
    }
    const ce = o(
            'accept,accept-charset,accesskey,action,align,allow,alt,async,autocapitalize,autocomplete,autofocus,autoplay,background,bgcolor,border,buffered,capture,challenge,charset,checked,cite,class,code,codebase,color,cols,colspan,content,contenteditable,contextmenu,controls,coords,crossorigin,csp,data,datetime,decoding,default,defer,dir,dirname,disabled,download,draggable,dropzone,enctype,enterkeyhint,for,form,formaction,formenctype,formmethod,formnovalidate,formtarget,headers,height,hidden,high,href,hreflang,http-equiv,icon,id,importance,inert,integrity,ismap,itemprop,keytype,kind,label,lang,language,loading,list,loop,low,manifest,max,maxlength,minlength,media,min,multiple,muted,name,novalidate,open,optimum,pattern,ping,placeholder,poster,preload,radiogroup,readonly,referrerpolicy,rel,required,reversed,rows,rowspan,sandbox,scope,scoped,selected,shape,size,sizes,slot,span,spellcheck,src,srcdoc,srclang,srcset,start,step,style,summary,tabindex,target,title,translate,type,usemap,value,width,wrap'
        ),
        de = o(
            'xmlns,accent-height,accumulate,additive,alignment-baseline,alphabetic,amplitude,arabic-form,ascent,attributeName,attributeType,azimuth,baseFrequency,baseline-shift,baseProfile,bbox,begin,bias,by,calcMode,cap-height,class,clip,clipPathUnits,clip-path,clip-rule,color,color-interpolation,color-interpolation-filters,color-profile,color-rendering,contentScriptType,contentStyleType,crossorigin,cursor,cx,cy,d,decelerate,descent,diffuseConstant,direction,display,divisor,dominant-baseline,dur,dx,dy,edgeMode,elevation,enable-background,end,exponent,fill,fill-opacity,fill-rule,filter,filterRes,filterUnits,flood-color,flood-opacity,font-family,font-size,font-size-adjust,font-stretch,font-style,font-variant,font-weight,format,from,fr,fx,fy,g1,g2,glyph-name,glyph-orientation-horizontal,glyph-orientation-vertical,glyphRef,gradientTransform,gradientUnits,hanging,height,href,hreflang,horiz-adv-x,horiz-origin-x,id,ideographic,image-rendering,in,in2,intercept,k,k1,k2,k3,k4,kernelMatrix,kernelUnitLength,kerning,keyPoints,keySplines,keyTimes,lang,lengthAdjust,letter-spacing,lighting-color,limitingConeAngle,local,marker-end,marker-mid,marker-start,markerHeight,markerUnits,markerWidth,mask,maskContentUnits,maskUnits,mathematical,max,media,method,min,mode,name,numOctaves,offset,opacity,operator,order,orient,orientation,origin,overflow,overline-position,overline-thickness,panose-1,paint-order,path,pathLength,patternContentUnits,patternTransform,patternUnits,ping,pointer-events,points,pointsAtX,pointsAtY,pointsAtZ,preserveAlpha,preserveAspectRatio,primitiveUnits,r,radius,referrerPolicy,refX,refY,rel,rendering-intent,repeatCount,repeatDur,requiredExtensions,requiredFeatures,restart,result,rotate,rx,ry,scale,seed,shape-rendering,slope,spacing,specularConstant,specularExponent,speed,spreadMethod,startOffset,stdDeviation,stemh,stemv,stitchTiles,stop-color,stop-opacity,strikethrough-position,strikethrough-thickness,string,stroke,stroke-dasharray,stroke-dashoffset,stroke-linecap,stroke-linejoin,stroke-miterlimit,stroke-opacity,stroke-width,style,surfaceScale,systemLanguage,tabindex,tableValues,target,targetX,targetY,text-anchor,text-decoration,text-rendering,textLength,to,transform,transform-origin,type,u1,u2,underline-position,underline-thickness,unicode,unicode-bidi,unicode-range,units-per-em,v-alphabetic,v-hanging,v-ideographic,v-mathematical,values,vector-effect,version,vert-adv-y,vert-origin-x,vert-origin-y,viewBox,viewTarget,visibility,width,widths,word-spacing,writing-mode,x,x-height,x1,x2,xChannelSelector,xlink:actuate,xlink:arcrole,xlink:href,xlink:role,xlink:show,xlink:title,xlink:type,xmlns:xlink,xml:base,xml:lang,xml:space,y,y1,y2,yChannelSelector,z,zoomAndPan'
        ),
        ue = /[ !"#$%&'()*+,./:;<=>?@[\\\]^`{|}~]/g;
    function pe(e, t) {
        return e.replace(ue, e => (t ? ('"' === e ? '\\\\\\"' : `\\\\${e}`) : `\\${e}`));
    }
    function fe(e, t) {
        if (e === t) return !0;
        let n = y(e),
            r = y(t);
        if (n || r) return !(!n || !r) && e.getTime() === t.getTime();
        if (((n = S(e)), (r = S(t)), n || r)) return e === t;
        if (((n = m(e)), (r = m(t)), n || r))
            return (
                !(!n || !r) &&
                (function (e, t) {
                    if (e.length !== t.length) return !1;
                    let n = !0;
                    for (let r = 0; n && r < e.length; r++) n = fe(e[r], t[r]);
                    return n;
                })(e, t)
            );
        if (((n = x(e)), (r = x(t)), n || r)) {
            if (!n || !r) return !1;
            if (Object.keys(e).length !== Object.keys(t).length) return !1;
            for (const n in e) {
                const r = e.hasOwnProperty(n),
                    o = t.hasOwnProperty(n);
                if ((r && !o) || (!r && o) || !fe(e[n], t[n])) return !1;
            }
        }
        return String(e) === String(t);
    }
    function he(e, t) {
        return e.findIndex(e => fe(e, t));
    }
    const me = e => !(!e || !0 !== e.__v_isRef),
        ge = e =>
            w(e)
                ? e
                : null == e
                  ? ''
                  : m(e) || (x(e) && (e.toString === T || !b(e.toString)))
                    ? me(e)
                        ? ge(e.value)
                        : JSON.stringify(e, ve, 2)
                    : String(e),
        ve = (e, t) =>
            me(t)
                ? ve(e, t.value)
                : g(t)
                  ? {
                        [`Map(${t.size})`]: [...t.entries()].reduce(
                            (e, [t, n], r) => ((e[ye(t, r) + ' =>'] = n), e),
                            {}
                        )
                    }
                  : v(t)
                    ? { [`Set(${t.size})`]: [...t.values()].map(e => ye(e)) }
                    : S(t)
                      ? ye(t)
                      : !x(t) || m(t) || E(t)
                        ? t
                        : String(t),
        ye = (e, t = '') => {
            var n;
            return S(e) ? `Symbol(${null != (n = e.description) ? n : t})` : e;
        };
    function be(e) {
        return null == e
            ? 'initial'
            : 'string' == typeof e
              ? '' === e
                  ? ' '
                  : e
              : (('number' == typeof e && Number.isFinite(e)) ||
                    console.warn(
                        '[Vue warn] Invalid value used for CSS binding. Expected a string or a finite number but received:',
                        e
                    ),
                String(e));
    }
    function we(e, ...t) {
        console.warn(`[Vue warn] ${e}`, ...t);
    }
    let Se, xe;
    class _e {
        constructor(e = !1) {
            ((this.detached = e),
                (this._active = !0),
                (this._on = 0),
                (this.effects = []),
                (this.cleanups = []),
                (this._isPaused = !1),
                (this.parent = Se),
                !e && Se && (this.index = (Se.scopes || (Se.scopes = [])).push(this) - 1));
        }
        get active() {
            return this._active;
        }
        pause() {
            if (this._active) {
                let e, t;
                if (((this._isPaused = !0), this.scopes))
                    for (e = 0, t = this.scopes.length; e < t; e++) this.scopes[e].pause();
                for (e = 0, t = this.effects.length; e < t; e++) this.effects[e].pause();
            }
        }
        resume() {
            if (this._active && this._isPaused) {
                let e, t;
                if (((this._isPaused = !1), this.scopes))
                    for (e = 0, t = this.scopes.length; e < t; e++) this.scopes[e].resume();
                for (e = 0, t = this.effects.length; e < t; e++) this.effects[e].resume();
            }
        }
        run(e) {
            if (this._active) {
                const t = Se;
                try {
                    return ((Se = this), e());
                } finally {
                    Se = t;
                }
            } else we('cannot run an inactive effect scope.');
        }
        on() {
            1 === ++this._on && ((this.prevScope = Se), (Se = this));
        }
        off() {
            this._on > 0 && 0 === --this._on && ((Se = this.prevScope), (this.prevScope = void 0));
        }
        stop(e) {
            if (this._active) {
                let t, n;
                for (this._active = !1, t = 0, n = this.effects.length; t < n; t++) this.effects[t].stop();
                for (this.effects.length = 0, t = 0, n = this.cleanups.length; t < n; t++) this.cleanups[t]();
                if (((this.cleanups.length = 0), this.scopes)) {
                    for (t = 0, n = this.scopes.length; t < n; t++) this.scopes[t].stop(!0);
                    this.scopes.length = 0;
                }
                if (!this.detached && this.parent && !e) {
                    const e = this.parent.scopes.pop();
                    e && e !== this && ((this.parent.scopes[this.index] = e), (e.index = this.index));
                }
                this.parent = void 0;
            }
        }
    }
    function Te(e) {
        return new _e(e);
    }
    function Ce() {
        return Se;
    }
    function ke(e, t = !1) {
        Se
            ? Se.cleanups.push(e)
            : t || we('onScopeDispose() is called when there is no active effect scope to be associated with.');
    }
    const Ee = new WeakSet();
    class Ae {
        constructor(e) {
            ((this.fn = e),
                (this.deps = void 0),
                (this.depsTail = void 0),
                (this.flags = 5),
                (this.next = void 0),
                (this.cleanup = void 0),
                (this.scheduler = void 0),
                Se && Se.active && Se.effects.push(this));
        }
        pause() {
            this.flags |= 64;
        }
        resume() {
            64 & this.flags && ((this.flags &= -65), Ee.has(this) && (Ee.delete(this), this.trigger()));
        }
        notify() {
            (2 & this.flags && !(32 & this.flags)) || 8 & this.flags || Pe(this);
        }
        run() {
            if (!(1 & this.flags)) return this.fn();
            ((this.flags |= 2), Ge(this), Re(this));
            const e = xe,
                t = He;
            ((xe = this), (He = !0));
            try {
                return this.fn();
            } finally {
                (xe !== this && we('Active effect was not restored correctly - this is likely a Vue internal bug.'),
                    $e(this),
                    (xe = e),
                    (He = t),
                    (this.flags &= -3));
            }
        }
        stop() {
            if (1 & this.flags) {
                for (let e = this.deps; e; e = e.nextDep) De(e);
                ((this.deps = this.depsTail = void 0), Ge(this), this.onStop && this.onStop(), (this.flags &= -2));
            }
        }
        trigger() {
            64 & this.flags ? Ee.add(this) : this.scheduler ? this.scheduler() : this.runIfDirty();
        }
        runIfDirty() {
            Be(this) && this.run();
        }
        get dirty() {
            return Be(this);
        }
    }
    let Oe,
        Ie,
        Me = 0;
    function Pe(e, t = !1) {
        if (((e.flags |= 8), t)) return ((e.next = Ie), void (Ie = e));
        ((e.next = Oe), (Oe = e));
    }
    function Ne() {
        Me++;
    }
    function Le() {
        if (--Me > 0) return;
        if (Ie) {
            let e = Ie;
            for (Ie = void 0; e; ) {
                const t = e.next;
                ((e.next = void 0), (e.flags &= -9), (e = t));
            }
        }
        let e;
        for (; Oe; ) {
            let t = Oe;
            for (Oe = void 0; t; ) {
                const n = t.next;
                if (((t.next = void 0), (t.flags &= -9), 1 & t.flags))
                    try {
                        t.trigger();
                    } catch (t) {
                        e || (e = t);
                    }
                t = n;
            }
        }
        if (e) throw e;
    }
    function Re(e) {
        for (let t = e.deps; t; t = t.nextDep)
            ((t.version = -1), (t.prevActiveLink = t.dep.activeLink), (t.dep.activeLink = t));
    }
    function $e(e) {
        let t,
            n = e.depsTail,
            r = n;
        for (; r; ) {
            const e = r.prevDep;
            (-1 === r.version ? (r === n && (n = e), De(r), je(r)) : (t = r),
                (r.dep.activeLink = r.prevActiveLink),
                (r.prevActiveLink = void 0),
                (r = e));
        }
        ((e.deps = t), (e.depsTail = n));
    }
    function Be(e) {
        for (let t = e.deps; t; t = t.nextDep)
            if (t.dep.version !== t.version || (t.dep.computed && (Fe(t.dep.computed) || t.dep.version !== t.version)))
                return !0;
        return !!e._dirty;
    }
    function Fe(e) {
        if (4 & e.flags && !(16 & e.flags)) return;
        if (((e.flags &= -17), e.globalVersion === Ye)) return;
        if (((e.globalVersion = Ye), !e.isSSR && 128 & e.flags && ((!e.deps && !e._dirty) || !Be(e)))) return;
        e.flags |= 2;
        const t = e.dep,
            n = xe,
            r = He;
        ((xe = e), (He = !0));
        try {
            Re(e);
            const n = e.fn(e._value);
            (0 === t.version || F(n, e._value)) && ((e.flags |= 128), (e._value = n), t.version++);
        } catch (e) {
            throw (t.version++, e);
        } finally {
            ((xe = n), (He = r), $e(e), (e.flags &= -3));
        }
    }
    function De(e, t = !1) {
        const { dep: n, prevSub: r, nextSub: o } = e;
        if (
            (r && ((r.nextSub = o), (e.prevSub = void 0)),
            o && ((o.prevSub = r), (e.nextSub = void 0)),
            n.subsHead === e && (n.subsHead = o),
            n.subs === e && ((n.subs = r), !r && n.computed))
        ) {
            n.computed.flags &= -5;
            for (let e = n.computed.deps; e; e = e.nextDep) De(e, !0);
        }
        t || --n.sc || !n.map || n.map.delete(n.key);
    }
    function je(e) {
        const { prevDep: t, nextDep: n } = e;
        (t && ((t.nextDep = n), (e.prevDep = void 0)), n && ((n.prevDep = t), (e.nextDep = void 0)));
    }
    function Ve(e, t) {
        e.effect instanceof Ae && (e = e.effect.fn);
        const n = new Ae(e);
        t && u(n, t);
        try {
            n.run();
        } catch (e) {
            throw (n.stop(), e);
        }
        const r = n.run.bind(n);
        return ((r.effect = n), r);
    }
    function ze(e) {
        e.effect.stop();
    }
    let He = !0;
    const Ue = [];
    function qe() {
        (Ue.push(He), (He = !1));
    }
    function We() {
        const e = Ue.pop();
        He = void 0 === e || e;
    }
    function Ge(e) {
        const { cleanup: t } = e;
        if (((e.cleanup = void 0), t)) {
            const e = xe;
            xe = void 0;
            try {
                t();
            } finally {
                xe = e;
            }
        }
    }
    let Ye = 0;
    class Ke {
        constructor(e, t) {
            ((this.sub = e),
                (this.dep = t),
                (this.version = t.version),
                (this.nextDep = this.prevDep = this.nextSub = this.prevSub = this.prevActiveLink = void 0));
        }
    }
    class Xe {
        constructor(e) {
            ((this.computed = e),
                (this.version = 0),
                (this.activeLink = void 0),
                (this.subs = void 0),
                (this.map = void 0),
                (this.key = void 0),
                (this.sc = 0),
                (this.__v_skip = !0),
                (this.subsHead = void 0));
        }
        track(e) {
            if (!xe || !He || xe === this.computed) return;
            let t = this.activeLink;
            if (void 0 === t || t.sub !== xe)
                ((t = this.activeLink = new Ke(xe, this)),
                    xe.deps
                        ? ((t.prevDep = xe.depsTail), (xe.depsTail.nextDep = t), (xe.depsTail = t))
                        : (xe.deps = xe.depsTail = t),
                    Je(t));
            else if (-1 === t.version && ((t.version = this.version), t.nextDep)) {
                const e = t.nextDep;
                ((e.prevDep = t.prevDep),
                    t.prevDep && (t.prevDep.nextDep = e),
                    (t.prevDep = xe.depsTail),
                    (t.nextDep = void 0),
                    (xe.depsTail.nextDep = t),
                    (xe.depsTail = t),
                    xe.deps === t && (xe.deps = e));
            }
            return (xe.onTrack && xe.onTrack(u({ effect: xe }, e)), t);
        }
        trigger(e) {
            (this.version++, Ye++, this.notify(e));
        }
        notify(e) {
            Ne();
            try {
                for (let t = this.subsHead; t; t = t.nextSub)
                    !t.sub.onTrigger || 8 & t.sub.flags || t.sub.onTrigger(u({ effect: t.sub }, e));
                for (let e = this.subs; e; e = e.prevSub) e.sub.notify() && e.sub.dep.notify();
            } finally {
                Le();
            }
        }
    }
    function Je(e) {
        if ((e.dep.sc++, 4 & e.sub.flags)) {
            const t = e.dep.computed;
            if (t && !e.dep.subs) {
                t.flags |= 20;
                for (let e = t.deps; e; e = e.nextDep) Je(e);
            }
            const n = e.dep.subs;
            (n !== e && ((e.prevSub = n), n && (n.nextSub = e)),
                void 0 === e.dep.subsHead && (e.dep.subsHead = e),
                (e.dep.subs = e));
        }
    }
    const Qe = new WeakMap(),
        Ze = Symbol('Object iterate'),
        et = Symbol('Map keys iterate'),
        tt = Symbol('Array iterate');
    function nt(e, t, n) {
        if (He && xe) {
            let r = Qe.get(e);
            r || Qe.set(e, (r = new Map()));
            let o = r.get(n);
            (o || (r.set(n, (o = new Xe())), (o.map = r), (o.key = n)), o.track({ target: e, type: t, key: n }));
        }
    }
    function rt(e, t, n, r, o, i) {
        const s = Qe.get(e);
        if (!s) return void Ye++;
        const a = s => {
            s && s.trigger({ target: e, type: t, key: n, newValue: r, oldValue: o, oldTarget: i });
        };
        if ((Ne(), 'clear' === t)) s.forEach(a);
        else {
            const o = m(e),
                i = o && A(n);
            if (o && 'length' === n) {
                const e = Number(r);
                s.forEach((t, n) => {
                    ('length' === n || n === tt || (!S(n) && n >= e)) && a(t);
                });
            } else
                switch (((void 0 !== n || s.has(void 0)) && a(s.get(n)), i && a(s.get(tt)), t)) {
                    case 'add':
                        o ? i && a(s.get('length')) : (a(s.get(Ze)), g(e) && a(s.get(et)));
                        break;
                    case 'delete':
                        o || (a(s.get(Ze)), g(e) && a(s.get(et)));
                        break;
                    case 'set':
                        g(e) && a(s.get(Ze));
                }
        }
        Le();
    }
    function ot(e) {
        const t = Wt(e);
        return t === e ? t : (nt(t, 'iterate', tt), Ut(e) ? t : t.map(Yt));
    }
    function it(e) {
        return (nt((e = Wt(e)), 'iterate', tt), e);
    }
    function st(e, t) {
        return Ht(e) ? (zt(e) ? Kt(Yt(t)) : Kt(t)) : Yt(t);
    }
    const at = {
        __proto__: null,
        [Symbol.iterator]() {
            return lt(this, Symbol.iterator, e => st(this, e));
        },
        concat(...e) {
            return ot(this).concat(...e.map(e => (m(e) ? ot(e) : e)));
        },
        entries() {
            return lt(this, 'entries', e => ((e[1] = st(this, e[1])), e));
        },
        every(e, t) {
            return dt(this, 'every', e, t, void 0, arguments);
        },
        filter(e, t) {
            return dt(this, 'filter', e, t, e => e.map(e => st(this, e)), arguments);
        },
        find(e, t) {
            return dt(this, 'find', e, t, e => st(this, e), arguments);
        },
        findIndex(e, t) {
            return dt(this, 'findIndex', e, t, void 0, arguments);
        },
        findLast(e, t) {
            return dt(this, 'findLast', e, t, e => st(this, e), arguments);
        },
        findLastIndex(e, t) {
            return dt(this, 'findLastIndex', e, t, void 0, arguments);
        },
        forEach(e, t) {
            return dt(this, 'forEach', e, t, void 0, arguments);
        },
        includes(...e) {
            return pt(this, 'includes', e);
        },
        indexOf(...e) {
            return pt(this, 'indexOf', e);
        },
        join(e) {
            return ot(this).join(e);
        },
        lastIndexOf(...e) {
            return pt(this, 'lastIndexOf', e);
        },
        map(e, t) {
            return dt(this, 'map', e, t, void 0, arguments);
        },
        pop() {
            return ft(this, 'pop');
        },
        push(...e) {
            return ft(this, 'push', e);
        },
        reduce(e, ...t) {
            return ut(this, 'reduce', e, t);
        },
        reduceRight(e, ...t) {
            return ut(this, 'reduceRight', e, t);
        },
        shift() {
            return ft(this, 'shift');
        },
        some(e, t) {
            return dt(this, 'some', e, t, void 0, arguments);
        },
        splice(...e) {
            return ft(this, 'splice', e);
        },
        toReversed() {
            return ot(this).toReversed();
        },
        toSorted(e) {
            return ot(this).toSorted(e);
        },
        toSpliced(...e) {
            return ot(this).toSpliced(...e);
        },
        unshift(...e) {
            return ft(this, 'unshift', e);
        },
        values() {
            return lt(this, 'values', e => st(this, e));
        }
    };
    function lt(e, t, n) {
        const r = it(e),
            o = r[t]();
        return (
            r === e ||
                Ut(e) ||
                ((o._next = o.next),
                (o.next = () => {
                    const e = o._next();
                    return (e.done || (e.value = n(e.value)), e);
                })),
            o
        );
    }
    const ct = Array.prototype;
    function dt(e, t, n, r, o, i) {
        const s = it(e),
            a = s !== e && !Ut(e),
            l = s[t];
        if (l !== ct[t]) {
            const t = l.apply(e, i);
            return a ? Yt(t) : t;
        }
        let c = n;
        s !== e &&
            (a
                ? (c = function (t, r) {
                      return n.call(this, st(e, t), r, e);
                  })
                : n.length > 2 &&
                  (c = function (t, r) {
                      return n.call(this, t, r, e);
                  }));
        const d = l.call(s, c, r);
        return a && o ? o(d) : d;
    }
    function ut(e, t, n, r) {
        const o = it(e);
        let i = n;
        return (
            o !== e &&
                (Ut(e)
                    ? n.length > 3 &&
                      (i = function (t, r, o) {
                          return n.call(this, t, r, o, e);
                      })
                    : (i = function (t, r, o) {
                          return n.call(this, t, st(e, r), o, e);
                      })),
            o[t](i, ...r)
        );
    }
    function pt(e, t, n) {
        const r = Wt(e);
        nt(r, 'iterate', tt);
        const o = r[t](...n);
        return (-1 !== o && !1 !== o) || !qt(n[0]) ? o : ((n[0] = Wt(n[0])), r[t](...n));
    }
    function ft(e, t, n = []) {
        (qe(), Ne());
        const r = Wt(e)[t].apply(e, n);
        return (Le(), We(), r);
    }
    const ht = o('__proto__,__v_isRef,__isVue'),
        mt = new Set(
            Object.getOwnPropertyNames(Symbol)
                .filter(e => 'arguments' !== e && 'caller' !== e)
                .map(e => Symbol[e])
                .filter(S)
        );
    function gt(e) {
        S(e) || (e = String(e));
        const t = Wt(this);
        return (nt(t, 'has', e), t.hasOwnProperty(e));
    }
    class vt {
        constructor(e = !1, t = !1) {
            ((this._isReadonly = e), (this._isShallow = t));
        }
        get(e, t, n) {
            if ('__v_skip' === t) return e.__v_skip;
            const r = this._isReadonly,
                o = this._isShallow;
            if ('__v_isReactive' === t) return !r;
            if ('__v_isReadonly' === t) return r;
            if ('__v_isShallow' === t) return o;
            if ('__v_raw' === t)
                return n === (r ? (o ? $t : Rt) : o ? Lt : Nt).get(e) ||
                    Object.getPrototypeOf(e) === Object.getPrototypeOf(n)
                    ? e
                    : void 0;
            const i = m(e);
            if (!r) {
                let e;
                if (i && (e = at[t])) return e;
                if ('hasOwnProperty' === t) return gt;
            }
            const s = Reflect.get(e, t, Xt(e) ? e : n);
            if (S(t) ? mt.has(t) : ht(t)) return s;
            if ((r || nt(e, 'get', t), o)) return s;
            if (Xt(s)) {
                const e = i && A(t) ? s : s.value;
                return r && x(e) ? Dt(e) : e;
            }
            return x(s) ? (r ? Dt(s) : Bt(s)) : s;
        }
    }
    class yt extends vt {
        constructor(e = !1) {
            super(!1, e);
        }
        set(e, t, n, r) {
            let o = e[t];
            const i = m(e) && A(t);
            if (!this._isShallow) {
                const r = Ht(o);
                if ((Ut(n) || Ht(n) || ((o = Wt(o)), (n = Wt(n))), !i && Xt(o) && !Xt(n)))
                    return r
                        ? (we(`Set operation on key "${String(t)}" failed: target is readonly.`, e[t]), !0)
                        : ((o.value = n), !0);
            }
            const s = i ? Number(t) < e.length : h(e, t),
                a = Reflect.set(e, t, n, Xt(e) ? e : r);
            return (e === Wt(r) && (s ? F(n, o) && rt(e, 'set', t, n, o) : rt(e, 'add', t, n)), a);
        }
        deleteProperty(e, t) {
            const n = h(e, t),
                r = e[t],
                o = Reflect.deleteProperty(e, t);
            return (o && n && rt(e, 'delete', t, void 0, r), o);
        }
        has(e, t) {
            const n = Reflect.has(e, t);
            return ((S(t) && mt.has(t)) || nt(e, 'has', t), n);
        }
        ownKeys(e) {
            return (nt(e, 'iterate', m(e) ? 'length' : Ze), Reflect.ownKeys(e));
        }
    }
    class bt extends vt {
        constructor(e = !1) {
            super(!0, e);
        }
        set(e, t) {
            return (we(`Set operation on key "${String(t)}" failed: target is readonly.`, e), !0);
        }
        deleteProperty(e, t) {
            return (we(`Delete operation on key "${String(t)}" failed: target is readonly.`, e), !0);
        }
    }
    const wt = new yt(),
        St = new bt(),
        xt = new yt(!0),
        _t = new bt(!0),
        Tt = e => e,
        Ct = e => Reflect.getPrototypeOf(e);
    function kt(e) {
        return function (...t) {
            {
                const n = t[0] ? `on key "${t[0]}" ` : '';
                we(`${$(e)} operation ${n}failed: target is readonly.`, Wt(this));
            }
            return 'delete' !== e && ('clear' === e ? void 0 : this);
        };
    }
    function Et(e, t) {
        const n = (function (e, t) {
            const n = {
                get(n) {
                    const r = this.__v_raw,
                        o = Wt(r),
                        i = Wt(n);
                    e || (F(n, i) && nt(o, 'get', n), nt(o, 'get', i));
                    const { has: s } = Ct(o),
                        a = t ? Tt : e ? Kt : Yt;
                    return s.call(o, n) ? a(r.get(n)) : s.call(o, i) ? a(r.get(i)) : void (r !== o && r.get(n));
                },
                get size() {
                    const t = this.__v_raw;
                    return (!e && nt(Wt(t), 'iterate', Ze), t.size);
                },
                has(t) {
                    const n = this.__v_raw,
                        r = Wt(n),
                        o = Wt(t);
                    return (
                        e || (F(t, o) && nt(r, 'has', t), nt(r, 'has', o)),
                        t === o ? n.has(t) : n.has(t) || n.has(o)
                    );
                },
                forEach(n, r) {
                    const o = this,
                        i = o.__v_raw,
                        s = Wt(i),
                        a = t ? Tt : e ? Kt : Yt;
                    return (!e && nt(s, 'iterate', Ze), i.forEach((e, t) => n.call(r, a(e), a(t), o)));
                }
            };
            return (
                u(
                    n,
                    e
                        ? { add: kt('add'), set: kt('set'), delete: kt('delete'), clear: kt('clear') }
                        : {
                              add(e) {
                                  t || Ut(e) || Ht(e) || (e = Wt(e));
                                  const n = Wt(this);
                                  return (Ct(n).has.call(n, e) || (n.add(e), rt(n, 'add', e, e)), this);
                              },
                              set(e, n) {
                                  t || Ut(n) || Ht(n) || (n = Wt(n));
                                  const r = Wt(this),
                                      { has: o, get: i } = Ct(r);
                                  let s = o.call(r, e);
                                  s ? Pt(r, o, e) : ((e = Wt(e)), (s = o.call(r, e)));
                                  const a = i.call(r, e);
                                  return (r.set(e, n), s ? F(n, a) && rt(r, 'set', e, n, a) : rt(r, 'add', e, n), this);
                              },
                              delete(e) {
                                  const t = Wt(this),
                                      { has: n, get: r } = Ct(t);
                                  let o = n.call(t, e);
                                  o ? Pt(t, n, e) : ((e = Wt(e)), (o = n.call(t, e)));
                                  const i = r ? r.call(t, e) : void 0,
                                      s = t.delete(e);
                                  return (o && rt(t, 'delete', e, void 0, i), s);
                              },
                              clear() {
                                  const e = Wt(this),
                                      t = 0 !== e.size,
                                      n = g(e) ? new Map(e) : new Set(e),
                                      r = e.clear();
                                  return (t && rt(e, 'clear', void 0, void 0, n), r);
                              }
                          }
                ),
                ['keys', 'values', 'entries', Symbol.iterator].forEach(r => {
                    n[r] = (function (e, t, n) {
                        return function (...r) {
                            const o = this.__v_raw,
                                i = Wt(o),
                                s = g(i),
                                a = 'entries' === e || (e === Symbol.iterator && s),
                                l = 'keys' === e && s,
                                c = o[e](...r),
                                d = n ? Tt : t ? Kt : Yt;
                            return (
                                !t && nt(i, 'iterate', l ? et : Ze),
                                {
                                    next() {
                                        const { value: e, done: t } = c.next();
                                        return t
                                            ? { value: e, done: t }
                                            : { value: a ? [d(e[0]), d(e[1])] : d(e), done: t };
                                    },
                                    [Symbol.iterator]() {
                                        return this;
                                    }
                                }
                            );
                        };
                    })(r, e, t);
                }),
                n
            );
        })(e, t);
        return (t, r, o) =>
            '__v_isReactive' === r
                ? !e
                : '__v_isReadonly' === r
                  ? e
                  : '__v_raw' === r
                    ? t
                    : Reflect.get(h(n, r) && r in t ? n : t, r, o);
    }
    const At = { get: Et(!1, !1) },
        Ot = { get: Et(!1, !0) },
        It = { get: Et(!0, !1) },
        Mt = { get: Et(!0, !0) };
    function Pt(e, t, n) {
        const r = Wt(n);
        if (r !== n && t.call(e, r)) {
            const t = k(e);
            we(
                `Reactive ${t} contains both the raw and reactive versions of the same object${'Map' === t ? ' as keys' : ''}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`
            );
        }
    }
    const Nt = new WeakMap(),
        Lt = new WeakMap(),
        Rt = new WeakMap(),
        $t = new WeakMap();
    function Bt(e) {
        return Ht(e) ? e : Vt(e, !1, wt, At, Nt);
    }
    function Ft(e) {
        return Vt(e, !1, xt, Ot, Lt);
    }
    function Dt(e) {
        return Vt(e, !0, St, It, Rt);
    }
    function jt(e) {
        return Vt(e, !0, _t, Mt, $t);
    }
    function Vt(e, t, n, r, o) {
        if (!x(e)) return (we(`value cannot be made ${t ? 'readonly' : 'reactive'}: ${String(e)}`), e);
        if (e.__v_raw && (!t || !e.__v_isReactive)) return e;
        const i =
            (s = e).__v_skip || !Object.isExtensible(s)
                ? 0
                : (function (e) {
                      switch (e) {
                          case 'Object':
                          case 'Array':
                              return 1;
                          case 'Map':
                          case 'Set':
                          case 'WeakMap':
                          case 'WeakSet':
                              return 2;
                          default:
                              return 0;
                      }
                  })(k(s));
        var s;
        if (0 === i) return e;
        const a = o.get(e);
        if (a) return a;
        const l = new Proxy(e, 2 === i ? r : n);
        return (o.set(e, l), l);
    }
    function zt(e) {
        return Ht(e) ? zt(e.__v_raw) : !(!e || !e.__v_isReactive);
    }
    function Ht(e) {
        return !(!e || !e.__v_isReadonly);
    }
    function Ut(e) {
        return !(!e || !e.__v_isShallow);
    }
    function qt(e) {
        return !!e && !!e.__v_raw;
    }
    function Wt(e) {
        const t = e && e.__v_raw;
        return t ? Wt(t) : e;
    }
    function Gt(e) {
        return (!h(e, '__v_skip') && Object.isExtensible(e) && j(e, '__v_skip', !0), e);
    }
    const Yt = e => (x(e) ? Bt(e) : e),
        Kt = e => (x(e) ? Dt(e) : e);
    function Xt(e) {
        return !!e && !0 === e.__v_isRef;
    }
    function Jt(e) {
        return Zt(e, !1);
    }
    function Qt(e) {
        return Zt(e, !0);
    }
    function Zt(e, t) {
        return Xt(e) ? e : new en(e, t);
    }
    class en {
        constructor(e, t) {
            ((this.dep = new Xe()),
                (this.__v_isRef = !0),
                (this.__v_isShallow = !1),
                (this._rawValue = t ? e : Wt(e)),
                (this._value = t ? e : Yt(e)),
                (this.__v_isShallow = t));
        }
        get value() {
            return (this.dep.track({ target: this, type: 'get', key: 'value' }), this._value);
        }
        set value(e) {
            const t = this._rawValue,
                n = this.__v_isShallow || Ut(e) || Ht(e);
            ((e = n ? e : Wt(e)),
                F(e, t) &&
                    ((this._rawValue = e),
                    (this._value = n ? e : Yt(e)),
                    this.dep.trigger({ target: this, type: 'set', key: 'value', newValue: e, oldValue: t })));
        }
    }
    function tn(e) {
        e.dep && e.dep.trigger({ target: e, type: 'set', key: 'value', newValue: e._value });
    }
    function nn(e) {
        return Xt(e) ? e.value : e;
    }
    function rn(e) {
        return b(e) ? e() : nn(e);
    }
    const on = {
        get: (e, t, n) => ('__v_raw' === t ? e : nn(Reflect.get(e, t, n))),
        set: (e, t, n, r) => {
            const o = e[t];
            return Xt(o) && !Xt(n) ? ((o.value = n), !0) : Reflect.set(e, t, n, r);
        }
    };
    function sn(e) {
        return zt(e) ? e : new Proxy(e, on);
    }
    class an {
        constructor(e) {
            ((this.__v_isRef = !0), (this._value = void 0));
            const t = (this.dep = new Xe()),
                { get: n, set: r } = e(t.track.bind(t), t.trigger.bind(t));
            ((this._get = n), (this._set = r));
        }
        get value() {
            return (this._value = this._get());
        }
        set value(e) {
            this._set(e);
        }
    }
    function ln(e) {
        return new an(e);
    }
    function cn(e) {
        qt(e) || we('toRefs() expects a reactive object but received a plain one.');
        const t = m(e) ? new Array(e.length) : {};
        for (const n in e) t[n] = fn(e, n);
        return t;
    }
    class dn {
        constructor(e, t, n) {
            ((this._object = e),
                (this._key = t),
                (this._defaultValue = n),
                (this.__v_isRef = !0),
                (this._value = void 0),
                (this._raw = Wt(e)));
            let r = !0,
                o = e;
            if (!m(e) || !A(String(t)))
                do {
                    r = !qt(o) || Ut(o);
                } while (r && (o = o.__v_raw));
            this._shallow = r;
        }
        get value() {
            let e = this._object[this._key];
            return (this._shallow && (e = nn(e)), (this._value = void 0 === e ? this._defaultValue : e));
        }
        set value(e) {
            if (this._shallow && Xt(this._raw[this._key])) {
                const t = this._object[this._key];
                if (Xt(t)) return void (t.value = e);
            }
            this._object[this._key] = e;
        }
        get dep() {
            return (function (e, t) {
                const n = Qe.get(e);
                return n && n.get(t);
            })(this._raw, this._key);
        }
    }
    class un {
        constructor(e) {
            ((this._getter = e), (this.__v_isRef = !0), (this.__v_isReadonly = !0), (this._value = void 0));
        }
        get value() {
            return (this._value = this._getter());
        }
    }
    function pn(e, t, n) {
        return Xt(e) ? e : b(e) ? new un(e) : x(e) && arguments.length > 1 ? fn(e, t, n) : Jt(e);
    }
    function fn(e, t, n) {
        return new dn(e, t, n);
    }
    class hn {
        constructor(e, t, n) {
            ((this.fn = e),
                (this.setter = t),
                (this._value = void 0),
                (this.dep = new Xe(this)),
                (this.__v_isRef = !0),
                (this.deps = void 0),
                (this.depsTail = void 0),
                (this.flags = 16),
                (this.globalVersion = Ye - 1),
                (this.next = void 0),
                (this.effect = this),
                (this.__v_isReadonly = !t),
                (this.isSSR = n));
        }
        notify() {
            if (((this.flags |= 16), !(8 & this.flags || xe === this))) return (Pe(this, !0), !0);
        }
        get value() {
            const e = this.dep.track({ target: this, type: 'get', key: 'value' });
            return (Fe(this), e && (e.version = this.dep.version), this._value);
        }
        set value(e) {
            this.setter ? this.setter(e) : we('Write operation failed: computed value is readonly');
        }
    }
    const mn = { GET: 'get', HAS: 'has', ITERATE: 'iterate' },
        gn = { SET: 'set', ADD: 'add', DELETE: 'delete', CLEAR: 'clear' },
        vn = {},
        yn = new WeakMap();
    let bn;
    function wn() {
        return bn;
    }
    function Sn(e, t = !1, n = bn) {
        if (n) {
            let t = yn.get(n);
            (t || yn.set(n, (t = [])), t.push(e));
        } else t || we('onWatcherCleanup() was called when there was no active watcher to associate with.');
    }
    function xn(e, t = 1 / 0, n) {
        if (t <= 0 || !x(e) || e.__v_skip) return e;
        if (((n = n || new Map()).get(e) || 0) >= t) return e;
        if ((n.set(e, t), t--, Xt(e))) xn(e.value, t, n);
        else if (m(e)) for (let r = 0; r < e.length; r++) xn(e[r], t, n);
        else if (v(e) || g(e))
            e.forEach(e => {
                xn(e, t, n);
            });
        else if (E(e)) {
            for (const r in e) xn(e[r], t, n);
            for (const r of Object.getOwnPropertySymbols(e))
                Object.prototype.propertyIsEnumerable.call(e, r) && xn(e[r], t, n);
        }
        return e;
    }
    const _n = [];
    function Tn(e) {
        _n.push(e);
    }
    function Cn() {
        _n.pop();
    }
    let kn = !1;
    function En(e, ...t) {
        if (kn) return;
        ((kn = !0), qe());
        const n = _n.length ? _n[_n.length - 1].component : null,
            r = n && n.appContext.config.warnHandler,
            o = (function () {
                let e = _n[_n.length - 1];
                if (!e) return [];
                const t = [];
                for (; e; ) {
                    const n = t[0];
                    n && n.vnode === e ? n.recurseCount++ : t.push({ vnode: e, recurseCount: 0 });
                    const r = e.component && e.component.parent;
                    e = r && r.vnode;
                }
                return t;
            })();
        if (r)
            Nn(r, n, 11, [
                e +
                    t
                        .map(e => {
                            var t, n;
                            return null != (n = null == (t = e.toString) ? void 0 : t.call(e)) ? n : JSON.stringify(e);
                        })
                        .join(''),
                n && n.proxy,
                o.map(({ vnode: e }) => `at <${yl(n, e.type)}>`).join('\n'),
                o
            ]);
        else {
            const n = [`[Vue warn]: ${e}`, ...t];
            (o.length &&
                n.push(
                    '\n',
                    ...(function (e) {
                        const t = [];
                        return (
                            e.forEach((e, n) => {
                                t.push(
                                    ...(0 === n ? [] : ['\n']),
                                    ...(function ({ vnode: e, recurseCount: t }) {
                                        const n = t > 0 ? `... (${t} recursive calls)` : '',
                                            r = !!e.component && null == e.component.parent,
                                            o = ` at <${yl(e.component, e.type, r)}`,
                                            i = '>' + n;
                                        return e.props ? [o, ...An(e.props), i] : [o + i];
                                    })(e)
                                );
                            }),
                            t
                        );
                    })(o)
                ),
                console.warn(...n));
        }
        (We(), (kn = !1));
    }
    function An(e) {
        const t = [],
            n = Object.keys(e);
        return (
            n.slice(0, 3).forEach(n => {
                t.push(...On(n, e[n]));
            }),
            n.length > 3 && t.push(' ...'),
            t
        );
    }
    function On(e, t, n) {
        return w(t)
            ? ((t = JSON.stringify(t)), n ? t : [`${e}=${t}`])
            : 'number' == typeof t || 'boolean' == typeof t || null == t
              ? n
                  ? t
                  : [`${e}=${t}`]
              : Xt(t)
                ? ((t = On(e, Wt(t.value), !0)), n ? t : [`${e}=Ref<`, t, '>'])
                : b(t)
                  ? [`${e}=fn${t.name ? `<${t.name}>` : ''}`]
                  : ((t = Wt(t)), n ? t : [`${e}=`, t]);
    }
    function In(e, t) {
        void 0 !== e &&
            ('number' != typeof e
                ? En(`${t} is not a valid number - got ${JSON.stringify(e)}.`)
                : isNaN(e) && En(`${t} is NaN - the duration expression might be incorrect.`));
    }
    const Mn = {
            SETUP_FUNCTION: 0,
            0: 'SETUP_FUNCTION',
            RENDER_FUNCTION: 1,
            1: 'RENDER_FUNCTION',
            NATIVE_EVENT_HANDLER: 5,
            5: 'NATIVE_EVENT_HANDLER',
            COMPONENT_EVENT_HANDLER: 6,
            6: 'COMPONENT_EVENT_HANDLER',
            VNODE_HOOK: 7,
            7: 'VNODE_HOOK',
            DIRECTIVE_HOOK: 8,
            8: 'DIRECTIVE_HOOK',
            TRANSITION_HOOK: 9,
            9: 'TRANSITION_HOOK',
            APP_ERROR_HANDLER: 10,
            10: 'APP_ERROR_HANDLER',
            APP_WARN_HANDLER: 11,
            11: 'APP_WARN_HANDLER',
            FUNCTION_REF: 12,
            12: 'FUNCTION_REF',
            ASYNC_COMPONENT_LOADER: 13,
            13: 'ASYNC_COMPONENT_LOADER',
            SCHEDULER: 14,
            14: 'SCHEDULER',
            COMPONENT_UPDATE: 15,
            15: 'COMPONENT_UPDATE',
            APP_UNMOUNT_CLEANUP: 16,
            16: 'APP_UNMOUNT_CLEANUP'
        },
        Pn = {
            sp: 'serverPrefetch hook',
            bc: 'beforeCreate hook',
            c: 'created hook',
            bm: 'beforeMount hook',
            m: 'mounted hook',
            bu: 'beforeUpdate hook',
            u: 'updated',
            bum: 'beforeUnmount hook',
            um: 'unmounted hook',
            a: 'activated hook',
            da: 'deactivated hook',
            ec: 'errorCaptured hook',
            rtc: 'renderTracked hook',
            rtg: 'renderTriggered hook',
            0: 'setup function',
            1: 'render function',
            2: 'watcher getter',
            3: 'watcher callback',
            4: 'watcher cleanup function',
            5: 'native event handler',
            6: 'component event handler',
            7: 'vnode hook',
            8: 'directive hook',
            9: 'transition hook',
            10: 'app errorHandler',
            11: 'app warnHandler',
            12: 'ref function',
            13: 'async component loader',
            14: 'scheduler flush',
            15: 'component update',
            16: 'app unmount cleanup function'
        };
    function Nn(e, t, n, r) {
        try {
            return r ? e(...r) : e();
        } catch (e) {
            Rn(e, t, n);
        }
    }
    function Ln(e, t, n, r) {
        if (b(e)) {
            const o = Nn(e, t, n, r);
            return (
                o &&
                    _(o) &&
                    o.catch(e => {
                        Rn(e, t, n);
                    }),
                o
            );
        }
        if (m(e)) {
            const o = [];
            for (let i = 0; i < e.length; i++) o.push(Ln(e[i], t, n, r));
            return o;
        }
        En('Invalid value type passed to callWithAsyncErrorHandling(): ' + typeof e);
    }
    function Rn(e, t, n, r = !0) {
        const o = t ? t.vnode : null,
            { errorHandler: s, throwUnhandledErrorInProduction: a } = (t && t.appContext.config) || i;
        if (t) {
            let r = t.parent;
            const o = t.proxy,
                i = Pn[n];
            for (; r; ) {
                const t = r.ec;
                if (t) for (let n = 0; n < t.length; n++) if (!1 === t[n](e, o, i)) return;
                r = r.parent;
            }
            if (s) return (qe(), Nn(s, null, 10, [e, o, i]), void We());
        }
        !(function (e, t, n, r = !0) {
            {
                const o = Pn[t];
                if ((n && Tn(n), En('Unhandled error' + (o ? ` during execution of ${o}` : '')), n && Cn(), r)) throw e;
                console.error(e);
            }
        })(e, n, o, r);
    }
    const $n = [];
    let Bn = -1;
    const Fn = [];
    let Dn = null,
        jn = 0;
    const Vn = Promise.resolve();
    let zn = null;
    const Hn = 100;
    function Un(e) {
        const t = zn || Vn;
        return e ? t.then(this ? e.bind(this) : e) : t;
    }
    function qn(e) {
        if (!(1 & e.flags)) {
            const t = Xn(e),
                n = $n[$n.length - 1];
            (!n || (!(2 & e.flags) && t >= Xn(n))
                ? $n.push(e)
                : $n.splice(
                      (function (e) {
                          let t = Bn + 1,
                              n = $n.length;
                          for (; t < n; ) {
                              const r = (t + n) >>> 1,
                                  o = $n[r],
                                  i = Xn(o);
                              i < e || (i === e && 2 & o.flags) ? (t = r + 1) : (n = r);
                          }
                          return t;
                      })(t),
                      0,
                      e
                  ),
                (e.flags |= 1),
                Wn());
        }
    }
    function Wn() {
        zn || (zn = Vn.then(Jn));
    }
    function Gn(e) {
        (m(e)
            ? Fn.push(...e)
            : Dn && -1 === e.id
              ? Dn.splice(jn + 1, 0, e)
              : 1 & e.flags || (Fn.push(e), (e.flags |= 1)),
            Wn());
    }
    function Yn(e, t, n = Bn + 1) {
        for (t = t || new Map(); n < $n.length; n++) {
            const r = $n[n];
            if (r && 2 & r.flags) {
                if (e && r.id !== e.uid) continue;
                if (Qn(t, r)) continue;
                ($n.splice(n, 1), n--, 4 & r.flags && (r.flags &= -2), r(), 4 & r.flags || (r.flags &= -2));
            }
        }
    }
    function Kn(e) {
        if (Fn.length) {
            const t = [...new Set(Fn)].sort((e, t) => Xn(e) - Xn(t));
            if (((Fn.length = 0), Dn)) return void Dn.push(...t);
            for (Dn = t, e = e || new Map(), jn = 0; jn < Dn.length; jn++) {
                const t = Dn[jn];
                Qn(e, t) || (4 & t.flags && (t.flags &= -2), 8 & t.flags || t(), (t.flags &= -2));
            }
            ((Dn = null), (jn = 0));
        }
    }
    const Xn = e => (null == e.id ? (2 & e.flags ? -1 : 1 / 0) : e.id);
    function Jn(e) {
        e = e || new Map();
        const t = t => Qn(e, t);
        try {
            for (Bn = 0; Bn < $n.length; Bn++) {
                const e = $n[Bn];
                if (e && !(8 & e.flags)) {
                    if (t(e)) continue;
                    (4 & e.flags && (e.flags &= -2), Nn(e, e.i, e.i ? 15 : 14), 4 & e.flags || (e.flags &= -2));
                }
            }
        } finally {
            for (; Bn < $n.length; Bn++) {
                const e = $n[Bn];
                e && (e.flags &= -2);
            }
            ((Bn = -1), ($n.length = 0), Kn(e), (zn = null), ($n.length || Fn.length) && Jn(e));
        }
    }
    function Qn(e, t) {
        const n = e.get(t) || 0;
        if (n > Hn) {
            const e = t.i,
                n = e && vl(e.type);
            return (
                Rn(
                    `Maximum recursive updates exceeded${n ? ` in component <${n}>` : ''}. This means you have a reactive effect that is mutating its own dependencies and thus recursively triggering itself. Possible sources include component template, render function, updated hook or watcher source function.`,
                    null,
                    10
                ),
                !0
            );
        }
        return (e.set(t, n + 1), !1);
    }
    let Zn = !1;
    const er = new Map();
    U().__VUE_HMR_RUNTIME__ = {
        createRecord: ir(nr),
        rerender: ir(function (e, t) {
            const n = tr.get(e);
            n &&
                ((n.initialDef.render = t),
                [...n.instances].forEach(e => {
                    (t && ((e.render = t), (rr(e.type).render = t)),
                        (e.renderCache = []),
                        (Zn = !0),
                        8 & e.job.flags || e.update(),
                        (Zn = !1));
                }));
        }),
        reload: ir(function (e, t) {
            const n = tr.get(e);
            if (!n) return;
            ((t = rr(t)), or(n.initialDef, t));
            const r = [...n.instances];
            for (let e = 0; e < r.length; e++) {
                const o = r[e],
                    i = rr(o.type);
                let s = er.get(i);
                (s || (i !== n.initialDef && or(i, t), er.set(i, (s = new Set()))),
                    s.add(o),
                    o.appContext.propsCache.delete(o.type),
                    o.appContext.emitsCache.delete(o.type),
                    o.appContext.optionsCache.delete(o.type),
                    o.ceReload
                        ? (s.add(o), o.ceReload(t.styles), s.delete(o))
                        : o.parent
                          ? qn(() => {
                                8 & o.job.flags || ((Zn = !0), o.parent.update(), (Zn = !1), s.delete(o));
                            })
                          : o.appContext.reload
                            ? o.appContext.reload()
                            : 'undefined' != typeof window
                              ? window.location.reload()
                              : console.warn('[HMR] Root or manually mounted instance modified. Full reload required.'),
                    o.root.ce && o !== o.root && o.root.ce._removeChildStyle(i));
            }
            Gn(() => {
                er.clear();
            });
        })
    };
    const tr = new Map();
    function nr(e, t) {
        return !tr.has(e) && (tr.set(e, { initialDef: rr(t), instances: new Set() }), !0);
    }
    function rr(e) {
        return bl(e) ? e.__vccOpts : e;
    }
    function or(e, t) {
        u(e, t);
        for (const n in e) '__file' === n || n in t || delete e[n];
    }
    function ir(e) {
        return (t, n) => {
            try {
                return e(t, n);
            } catch (e) {
                (console.error(e),
                    console.warn('[HMR] Something went wrong during Vue component hot-reload. Full reload required.'));
            }
        };
    }
    let sr,
        ar = [],
        lr = !1;
    function cr(e, ...t) {
        sr ? sr.emit(e, ...t) : lr || ar.push({ event: e, args: t });
    }
    function dr(e, t) {
        var n, r;
        ((sr = e),
            sr
                ? ((sr.enabled = !0), ar.forEach(({ event: e, args: t }) => sr.emit(e, ...t)), (ar = []))
                : 'undefined' != typeof window &&
                    window.HTMLElement &&
                    !(null == (r = null == (n = window.navigator) ? void 0 : n.userAgent)
                        ? void 0
                        : r.includes('jsdom'))
                  ? ((t.__VUE_DEVTOOLS_HOOK_REPLAY__ = t.__VUE_DEVTOOLS_HOOK_REPLAY__ || []).push(e => {
                        dr(e, t);
                    }),
                    setTimeout(() => {
                        sr || ((t.__VUE_DEVTOOLS_HOOK_REPLAY__ = null), (lr = !0), (ar = []));
                    }, 3e3))
                  : ((lr = !0), (ar = [])));
    }
    const ur = mr('component:added'),
        pr = mr('component:updated'),
        fr = mr('component:removed'),
        hr = e => {
            sr && 'function' == typeof sr.cleanupBuffer && !sr.cleanupBuffer(e) && fr(e);
        };
    function mr(e) {
        return t => {
            cr(e, t.appContext.app, t.uid, t.parent ? t.parent.uid : void 0, t);
        };
    }
    const gr = yr('perf:start'),
        vr = yr('perf:end');
    function yr(e) {
        return (t, n, r) => {
            cr(e, t.appContext.app, t.uid, t, n, r);
        };
    }
    let br = null,
        wr = null;
    function Sr(e) {
        const t = br;
        return ((br = e), (wr = (e && e.type.__scopeId) || null), t);
    }
    function xr(e) {
        wr = e;
    }
    function _r() {
        wr = null;
    }
    const Tr = e => Cr;
    function Cr(e, t = br, n) {
        if (!t) return e;
        if (e._n) return e;
        const r = (...n) => {
            r._d && Ta(-1);
            const o = Sr(t);
            let i;
            try {
                i = e(...n);
            } finally {
                (Sr(o), r._d && Ta(1));
            }
            return (pr(t), i);
        };
        return ((r._n = !0), (r._c = !0), (r._d = !0), r);
    }
    function kr(e) {
        I(e) && En('Do not use built-in directive ids as custom directive id: ' + e);
    }
    function Er(e, t) {
        if (null === br) return (En('withDirectives can only be used inside render functions.'), e);
        const n = hl(br),
            r = e.dirs || (e.dirs = []);
        for (let e = 0; e < t.length; e++) {
            let [o, s, a, l = i] = t[e];
            o &&
                (b(o) && (o = { mounted: o, updated: o }),
                o.deep && xn(s),
                r.push({ dir: o, instance: n, value: s, oldValue: void 0, arg: a, modifiers: l }));
        }
        return e;
    }
    function Ar(e, t, n, r) {
        const o = e.dirs,
            i = t && t.dirs;
        for (let s = 0; s < o.length; s++) {
            const a = o[s];
            i && (a.oldValue = i[s].value);
            let l = a.dir[r];
            l && (qe(), Ln(l, n, 8, [e.el, a, e, t]), We());
        }
    }
    const Or = Symbol('_vte'),
        Ir = e => e.__isTeleport,
        Mr = e => e && (e.disabled || '' === e.disabled),
        Pr = e => e && (e.defer || '' === e.defer),
        Nr = e => 'undefined' != typeof SVGElement && e instanceof SVGElement,
        Lr = e => 'function' == typeof MathMLElement && e instanceof MathMLElement,
        Rr = (e, t) => {
            const n = e && e.to;
            if (w(n)) {
                if (t) {
                    const r = t(n);
                    return (
                        r ||
                            Mr(e) ||
                            En(
                                `Failed to locate Teleport target with selector "${n}". Note the target element must exist before the component is mounted - i.e. the target cannot be rendered by the component itself, and ideally should be outside of the entire Vue component tree.`
                            ),
                        r
                    );
                }
                return (
                    En(
                        'Current renderer does not support string target for Teleports. (missing querySelector renderer option)'
                    ),
                    null
                );
            }
            return (n || Mr(e) || En(`Invalid Teleport target: ${n}`), n);
        },
        $r = {
            name: 'Teleport',
            __isTeleport: !0,
            process(e, t, n, r, o, i, s, a, l, c) {
                const {
                        mc: d,
                        pc: u,
                        pbc: p,
                        o: { insert: f, querySelector: h, createText: m, createComment: g }
                    } = c,
                    v = Mr(t.props);
                let { shapeFlag: y, children: b, dynamicChildren: w } = t;
                if ((Zn && ((l = !1), (w = null)), null == e)) {
                    const e = (t.el = g('teleport start')),
                        c = (t.anchor = g('teleport end'));
                    (f(e, n, r), f(c, n, r));
                    const u = (e, t) => {
                            16 & y && d(b, e, t, o, i, s, a, l);
                        },
                        p = () => {
                            const e = (t.target = Rr(t.props, h)),
                                n = jr(e, t, m, f);
                            e
                                ? ('svg' !== s && Nr(e) ? (s = 'svg') : 'mathml' !== s && Lr(e) && (s = 'mathml'),
                                  o && o.isCE && (o.ce._teleportTargets || (o.ce._teleportTargets = new Set())).add(e),
                                  v || (u(e, n), Dr(t, !1)))
                                : v || En('Invalid Teleport target on mount:', e, `(${typeof e})`);
                        };
                    (v && (u(n, c), Dr(t, !0)),
                        Pr(t.props)
                            ? ((t.el.__isMounted = !1),
                              Ks(() => {
                                  (p(), delete t.el.__isMounted);
                              }, i))
                            : p());
                } else {
                    if (Pr(t.props) && !1 === e.el.__isMounted)
                        return void Ks(() => {
                            $r.process(e, t, n, r, o, i, s, a, l, c);
                        }, i);
                    ((t.el = e.el), (t.targetStart = e.targetStart));
                    const d = (t.anchor = e.anchor),
                        f = (t.target = e.target),
                        m = (t.targetAnchor = e.targetAnchor),
                        g = Mr(e.props),
                        y = g ? n : f,
                        b = g ? d : m;
                    if (
                        ('svg' === s || Nr(f) ? (s = 'svg') : ('mathml' === s || Lr(f)) && (s = 'mathml'),
                        w ? (p(e.dynamicChildren, w, y, o, i, s, a), na(e, t, !1)) : l || u(e, t, y, b, o, i, s, a, !1),
                        v)
                    )
                        g
                            ? t.props && e.props && t.props.to !== e.props.to && (t.props.to = e.props.to)
                            : Br(t, n, d, c, 1);
                    else if ((t.props && t.props.to) !== (e.props && e.props.to)) {
                        const e = (t.target = Rr(t.props, h));
                        e ? Br(t, e, null, c, 0) : En('Invalid Teleport target on update:', f, `(${typeof f})`);
                    } else g && Br(t, f, m, c, 1);
                    Dr(t, v);
                }
            },
            remove(e, t, n, { um: r, o: { remove: o } }, i) {
                const {
                    shapeFlag: s,
                    children: a,
                    anchor: l,
                    targetStart: c,
                    targetAnchor: d,
                    target: u,
                    props: p
                } = e;
                if ((u && (o(c), o(d)), i && o(l), 16 & s)) {
                    const e = i || !Mr(p);
                    for (let o = 0; o < a.length; o++) {
                        const i = a[o];
                        r(i, t, n, e, !!i.dynamicChildren);
                    }
                }
            },
            move: Br,
            hydrate: function (
                e,
                t,
                n,
                r,
                o,
                i,
                { o: { nextSibling: s, parentNode: a, querySelector: l, insert: c, createText: d } },
                u
            ) {
                function p(e, t, l, c) {
                    ((t.anchor = u(s(e), t, a(e), n, r, o, i)), (t.targetStart = l), (t.targetAnchor = c));
                }
                const f = (t.target = Rr(t.props, l)),
                    h = Mr(t.props);
                if (f) {
                    const a = f._lpa || f.firstChild;
                    if (16 & t.shapeFlag)
                        if (h) p(e, t, a, a && s(a));
                        else {
                            t.anchor = s(e);
                            let l = a;
                            for (; l; ) {
                                if (l && 8 === l.nodeType)
                                    if ('teleport start anchor' === l.data) t.targetStart = l;
                                    else if ('teleport anchor' === l.data) {
                                        ((t.targetAnchor = l), (f._lpa = t.targetAnchor && s(t.targetAnchor)));
                                        break;
                                    }
                                l = s(l);
                            }
                            (t.targetAnchor || jr(f, t, d, c), u(a && s(a), t, f, n, r, o, i));
                        }
                    Dr(t, h);
                } else h && 16 & t.shapeFlag && p(e, t, e, s(e));
                return t.anchor && s(t.anchor);
            }
        };
    function Br(e, t, n, { o: { insert: r }, m: o }, i = 2) {
        0 === i && r(e.targetAnchor, t, n);
        const { el: s, anchor: a, shapeFlag: l, children: c, props: d } = e,
            u = 2 === i;
        if ((u && r(s, t, n), (!u || Mr(d)) && 16 & l)) for (let e = 0; e < c.length; e++) o(c[e], t, n, 2);
        u && r(a, t, n);
    }
    const Fr = $r;
    function Dr(e, t) {
        const n = e.ctx;
        if (n && n.ut) {
            let r, o;
            for (t ? ((r = e.el), (o = e.anchor)) : ((r = e.targetStart), (o = e.targetAnchor)); r && r !== o; )
                (1 === r.nodeType && r.setAttribute('data-v-owner', n.uid), (r = r.nextSibling));
            n.ut();
        }
    }
    function jr(e, t, n, r) {
        const o = (t.targetStart = n('')),
            i = (t.targetAnchor = n(''));
        return ((o[Or] = i), e && (r(o, e), r(i, e)), i);
    }
    const Vr = Symbol('_leaveCb'),
        zr = Symbol('_enterCb');
    function Hr() {
        const e = { isMounted: !1, isLeaving: !1, isUnmounting: !1, leavingVNodes: new Map() };
        return (
            Ho(() => {
                e.isMounted = !0;
            }),
            Wo(() => {
                e.isUnmounting = !0;
            }),
            e
        );
    }
    const Ur = [Function, Array],
        qr = {
            mode: String,
            appear: Boolean,
            persisted: Boolean,
            onBeforeEnter: Ur,
            onEnter: Ur,
            onAfterEnter: Ur,
            onEnterCancelled: Ur,
            onBeforeLeave: Ur,
            onLeave: Ur,
            onAfterLeave: Ur,
            onLeaveCancelled: Ur,
            onBeforeAppear: Ur,
            onAppear: Ur,
            onAfterAppear: Ur,
            onAppearCancelled: Ur
        },
        Wr = e => {
            const t = e.subTree;
            return t.component ? Wr(t.component) : t;
        };
    function Gr(e) {
        let t = e[0];
        if (e.length > 1) {
            let n = !1;
            for (const r of e)
                if (r.type !== ga) {
                    if (n) {
                        En(
                            '<transition> can only be used on a single element or component. Use <transition-group> for lists.'
                        );
                        break;
                    }
                    ((t = r), (n = !0));
                }
        }
        return t;
    }
    const Yr = {
        name: 'BaseTransition',
        props: qr,
        setup(e, { slots: t }) {
            const n = Xa(),
                r = Hr();
            return () => {
                const o = t.default && eo(t.default(), !0);
                if (!o || !o.length) return;
                const i = Gr(o),
                    s = Wt(e),
                    { mode: a } = s;
                if (
                    (a && 'in-out' !== a && 'out-in' !== a && 'default' !== a && En(`invalid <transition> mode: ${a}`),
                    r.isLeaving)
                )
                    return Jr(i);
                const l = Qr(i);
                if (!l) return Jr(i);
                let c = Xr(l, s, r, n, e => (c = e));
                l.type !== ga && Zr(l, c);
                let d = n.subTree && Qr(n.subTree);
                if (d && d.type !== ga && !Oa(d, l) && Wr(n).type !== ga) {
                    let e = Xr(d, s, r, n);
                    if ((Zr(d, e), 'out-in' === a && l.type !== ga))
                        return (
                            (r.isLeaving = !0),
                            (e.afterLeave = () => {
                                ((r.isLeaving = !1), 8 & n.job.flags || n.update(), delete e.afterLeave, (d = void 0));
                            }),
                            Jr(i)
                        );
                    'in-out' === a && l.type !== ga
                        ? (e.delayLeave = (e, t, n) => {
                              ((Kr(r, d)[String(d.key)] = d),
                                  (e[Vr] = () => {
                                      (t(), (e[Vr] = void 0), delete c.delayedLeave, (d = void 0));
                                  }),
                                  (c.delayedLeave = () => {
                                      (n(), delete c.delayedLeave, (d = void 0));
                                  }));
                          })
                        : (d = void 0);
                } else d && (d = void 0);
                return i;
            };
        }
    };
    function Kr(e, t) {
        const { leavingVNodes: n } = e;
        let r = n.get(t.type);
        return (r || ((r = Object.create(null)), n.set(t.type, r)), r);
    }
    function Xr(e, t, n, r, o) {
        const {
                appear: i,
                mode: s,
                persisted: a = !1,
                onBeforeEnter: l,
                onEnter: c,
                onAfterEnter: d,
                onEnterCancelled: u,
                onBeforeLeave: p,
                onLeave: f,
                onAfterLeave: h,
                onLeaveCancelled: g,
                onBeforeAppear: v,
                onAppear: y,
                onAfterAppear: b,
                onAppearCancelled: w
            } = t,
            S = String(e.key),
            x = Kr(n, e),
            _ = (e, t) => {
                e && Ln(e, r, 9, t);
            },
            T = (e, t) => {
                const n = t[1];
                (_(e, t), m(e) ? e.every(e => e.length <= 1) && n() : e.length <= 1 && n());
            },
            C = {
                mode: s,
                persisted: a,
                beforeEnter(t) {
                    let r = l;
                    if (!n.isMounted) {
                        if (!i) return;
                        r = v || l;
                    }
                    t[Vr] && t[Vr](!0);
                    const o = x[S];
                    (o && Oa(e, o) && o.el[Vr] && o.el[Vr](), _(r, [t]));
                },
                enter(e) {
                    let t = c,
                        r = d,
                        o = u;
                    if (!n.isMounted) {
                        if (!i) return;
                        ((t = y || c), (r = b || d), (o = w || u));
                    }
                    let s = !1;
                    const a = (e[zr] = t => {
                        s || ((s = !0), _(t ? o : r, [e]), C.delayedLeave && C.delayedLeave(), (e[zr] = void 0));
                    });
                    t ? T(t, [e, a]) : a();
                },
                leave(t, r) {
                    const o = String(e.key);
                    if ((t[zr] && t[zr](!0), n.isUnmounting)) return r();
                    _(p, [t]);
                    let i = !1;
                    const s = (t[Vr] = n => {
                        i || ((i = !0), r(), _(n ? g : h, [t]), (t[Vr] = void 0), x[o] === e && delete x[o]);
                    });
                    ((x[o] = e), f ? T(f, [t, s]) : s());
                },
                clone(e) {
                    const i = Xr(e, t, n, r, o);
                    return (o && o(i), i);
                }
            };
        return C;
    }
    function Jr(e) {
        if (Mo(e)) return (((e = $a(e)).children = null), e);
    }
    function Qr(e) {
        if (!Mo(e)) return Ir(e.type) && e.children ? Gr(e.children) : e;
        if (e.component) return e.component.subTree;
        const { shapeFlag: t, children: n } = e;
        if (n) {
            if (16 & t) return n[0];
            if (32 & t && b(n.default)) return n.default();
        }
    }
    function Zr(e, t) {
        6 & e.shapeFlag && e.component
            ? ((e.transition = t), Zr(e.component.subTree, t))
            : 128 & e.shapeFlag
              ? ((e.ssContent.transition = t.clone(e.ssContent)), (e.ssFallback.transition = t.clone(e.ssFallback)))
              : (e.transition = t);
    }
    function eo(e, t = !1, n) {
        let r = [],
            o = 0;
        for (let i = 0; i < e.length; i++) {
            let s = e[i];
            const a = null == n ? s.key : String(n) + String(null != s.key ? s.key : i);
            s.type === ha
                ? (128 & s.patchFlag && o++, (r = r.concat(eo(s.children, t, a))))
                : (t || s.type !== ga) && r.push(null != a ? $a(s, { key: a }) : s);
        }
        if (o > 1) for (let e = 0; e < r.length; e++) r[e].patchFlag = -2;
        return r;
    }
    function to(e, t) {
        return b(e) ? (() => u({ name: e.name }, t, { setup: e }))() : e;
    }
    function no() {
        const e = Xa();
        return e
            ? (e.appContext.config.idPrefix || 'v') + '-' + e.ids[0] + e.ids[1]++
            : (En('useId() is called when there is no active component instance to be associated with.'), '');
    }
    function ro(e) {
        e.ids = [e.ids[0] + e.ids[2]++ + '-', 0, 0];
    }
    const oo = new WeakSet();
    function io(e) {
        const t = Xa(),
            n = Qt(null);
        if (t) {
            const r = t.refs === i ? (t.refs = {}) : t.refs;
            let o;
            (o = Object.getOwnPropertyDescriptor(r, e)) && !o.configurable
                ? En(`useTemplateRef('${e}') already exists.`)
                : Object.defineProperty(r, e, { enumerable: !0, get: () => n.value, set: e => (n.value = e) });
        } else En('useTemplateRef() is called when there is no active component instance to be associated with.');
        const r = Dt(n);
        return (oo.add(r), r);
    }
    const so = new WeakMap();
    function ao(e, t, n, r, o = !1) {
        if (m(e)) return void e.forEach((e, i) => ao(e, t && (m(t) ? t[i] : t), n, r, o));
        if (Ao(r) && !o)
            return void (
                512 & r.shapeFlag &&
                r.type.__asyncResolved &&
                r.component.subTree.component &&
                ao(e, t, n, r.component.subTree)
            );
        const s = 4 & r.shapeFlag ? hl(r.component) : r.el,
            a = o ? null : s,
            { i: c, r: d } = e;
        if (!c)
            return void En(
                'Missing ref owner context. ref cannot be used on hoisted vnodes. A vnode with ref must be created inside the render function.'
            );
        const u = t && t.r,
            f = c.refs === i ? (c.refs = {}) : c.refs,
            g = c.setupState,
            v = Wt(g),
            y =
                g === i
                    ? l
                    : e => (
                          h(v, e) &&
                              !Xt(v[e]) &&
                              En(
                                  `Template ref "${e}" used on a non-ref value. It will not work in the production build.`
                              ),
                          !oo.has(v[e]) && h(v, e)
                      ),
            S = e => !oo.has(e);
        if (null != u && u !== d)
            if ((lo(t), w(u))) ((f[u] = null), y(u) && (g[u] = null));
            else if (Xt(u)) {
                S(u) && (u.value = null);
                const e = t;
                e.k && (f[e.k] = null);
            }
        if (b(d)) Nn(d, c, 12, [a, f]);
        else {
            const t = w(d),
                r = Xt(d);
            if (t || r) {
                const i = () => {
                    if (e.f) {
                        const n = t ? (y(d) ? g[d] : f[d]) : S(d) || !e.k ? d.value : f[e.k];
                        if (o) m(n) && p(n, s);
                        else if (m(n)) n.includes(s) || n.push(s);
                        else if (t) ((f[d] = [s]), y(d) && (g[d] = f[d]));
                        else {
                            const t = [s];
                            (S(d) && (d.value = t), e.k && (f[e.k] = t));
                        }
                    } else
                        t
                            ? ((f[d] = a), y(d) && (g[d] = a))
                            : r
                              ? (S(d) && (d.value = a), e.k && (f[e.k] = a))
                              : En('Invalid template ref type:', d, `(${typeof d})`);
                };
                if (a) {
                    const t = () => {
                        (i(), so.delete(e));
                    };
                    ((t.id = -1), so.set(e, t), Ks(t, n));
                } else (lo(e), i());
            } else En('Invalid template ref type:', d, `(${typeof d})`);
        }
    }
    function lo(e) {
        const t = so.get(e);
        t && ((t.flags |= 8), so.delete(e));
    }
    let co = !1;
    const uo = () => {
            co || (console.error('Hydration completed but contains mismatches.'), (co = !0));
        },
        po = e => {
            if (1 === e.nodeType)
                return (e => e.namespaceURI.includes('svg') && 'foreignObject' !== e.tagName)(e)
                    ? 'svg'
                    : (e => e.namespaceURI.includes('MathML'))(e)
                      ? 'mathml'
                      : void 0;
        },
        fo = e => 8 === e.nodeType;
    function ho(e) {
        const {
                mt: t,
                p: n,
                o: {
                    patchProp: r,
                    createText: o,
                    nextSibling: i,
                    parentNode: s,
                    remove: a,
                    insert: l,
                    createComment: d
                }
            } = e,
            u = (n, r, a, c, d, b = !1) => {
                b = b || !!r.dynamicChildren;
                const w = fo(n) && '[' === n.data,
                    S = () => m(n, r, a, c, d, w),
                    { type: x, ref: _, shapeFlag: T, patchFlag: C } = r;
                let k = n.nodeType;
                ((r.el = n),
                    j(n, '__vnode', r, !0),
                    j(n, '__vueParentComponent', a, !0),
                    -2 === C && ((b = !1), (r.dynamicChildren = null)));
                let E = null;
                switch (x) {
                    case ma:
                        3 !== k
                            ? '' === r.children
                                ? (l((r.el = o('')), s(n), n), (E = n))
                                : (E = S())
                            : (n.data !== r.children &&
                                  (En(
                                      'Hydration text mismatch in',
                                      n.parentNode,
                                      `\n  - rendered on server: ${JSON.stringify(n.data)}\n  - expected on client: ${JSON.stringify(r.children)}`
                                  ),
                                  uo(),
                                  (n.data = r.children)),
                              (E = i(n)));
                        break;
                    case ga:
                        y(n) ? ((E = i(n)), v((r.el = n.content.firstChild), n, a)) : (E = 8 !== k || w ? S() : i(n));
                        break;
                    case va:
                        if ((w && (k = (n = i(n)).nodeType), 1 === k || 3 === k)) {
                            E = n;
                            const e = !r.children.length;
                            for (let t = 0; t < r.staticCount; t++)
                                (e && (r.children += 1 === E.nodeType ? E.outerHTML : E.data),
                                    t === r.staticCount - 1 && (r.anchor = E),
                                    (E = i(E)));
                            return w ? i(E) : E;
                        }
                        S();
                        break;
                    case ha:
                        E = w ? h(n, r, a, c, d, b) : S();
                        break;
                    default:
                        if (1 & T)
                            E =
                                (1 === k && r.type.toLowerCase() === n.tagName.toLowerCase()) || y(n)
                                    ? p(n, r, a, c, d, b)
                                    : S();
                        else if (6 & T) {
                            r.slotScopeIds = d;
                            const e = s(n);
                            if (
                                ((E = w
                                    ? g(n)
                                    : fo(n) && 'teleport start' === n.data
                                      ? g(n, n.data, 'teleport end')
                                      : i(n)),
                                t(r, e, null, a, c, po(e), b),
                                Ao(r) && !r.type.__asyncResolved)
                            ) {
                                let t;
                                (w
                                    ? ((t = La(ha)), (t.anchor = E ? E.previousSibling : e.lastChild))
                                    : (t = 3 === n.nodeType ? Fa('') : La('div')),
                                    (t.el = n),
                                    (r.component.subTree = t));
                            }
                        } else
                            64 & T
                                ? (E = 8 !== k ? S() : r.type.hydrate(n, r, a, c, d, b, e, f))
                                : 128 & T
                                  ? (E = r.type.hydrate(n, r, a, c, po(s(n)), d, b, e, u))
                                  : En('Invalid HostVNode type:', x, `(${typeof x})`);
                }
                return (null != _ && ao(_, null, c, r), E);
            },
            p = (e, t, n, o, i, s) => {
                s = s || !!t.dynamicChildren;
                const { type: l, props: d, patchFlag: u, shapeFlag: p, dirs: h, transition: m } = t,
                    g = 'input' === l || 'option' === l;
                {
                    h && Ar(t, null, n, 'created');
                    let l,
                        u = !1;
                    if (y(e)) {
                        u = ta(null, m) && n && n.vnode.props && n.vnode.props.appear;
                        const r = e.content.firstChild;
                        if (u) {
                            const e = r.getAttribute('class');
                            (e && (r.$cls = e), m.beforeEnter(r));
                        }
                        (v(r, e, n), (t.el = e = r));
                    }
                    if (16 & p && (!d || (!d.innerHTML && !d.textContent))) {
                        let r = f(e.firstChild, t, e, n, o, i, s),
                            l = !1;
                        for (; r; ) {
                            So(e, 1) ||
                                (l ||
                                    (En(
                                        'Hydration children mismatch on',
                                        e,
                                        '\nServer rendered element contains more child nodes than client vdom.'
                                    ),
                                    (l = !0)),
                                uo());
                            const t = r;
                            ((r = r.nextSibling), a(t));
                        }
                    } else if (8 & p) {
                        let n = t.children;
                        '\n' !== n[0] || ('PRE' !== e.tagName && 'TEXTAREA' !== e.tagName) || (n = n.slice(1));
                        const { textContent: r } = e;
                        r !== n &&
                            r !== n.replace(/\r\n|\r/g, '\n') &&
                            (So(e, 0) ||
                                (En(
                                    'Hydration text content mismatch on',
                                    e,
                                    `\n  - rendered on server: ${r}\n  - expected on client: ${n}`
                                ),
                                uo()),
                            (e.textContent = t.children));
                    }
                    if (d) {
                        const o = e.tagName.includes('-');
                        for (const i in d)
                            ((h && h.some(e => e.dir.created)) || !mo(e, i, d[i], t, n) || uo(),
                                ((g && (i.endsWith('value') || 'indeterminate' === i)) ||
                                    (c(i) && !O(i)) ||
                                    '.' === i[0] ||
                                    o) &&
                                    r(e, i, null, d[i], void 0, n));
                    }
                    ((l = d && d.onVnodeBeforeMount) && qa(l, n, t),
                        h && Ar(t, null, n, 'beforeMount'),
                        ((l = d && d.onVnodeMounted) || h || u) &&
                            pa(() => {
                                (l && qa(l, n, t), u && m.enter(e), h && Ar(t, null, n, 'mounted'));
                            }, o));
                }
                return e.nextSibling;
            },
            f = (e, t, r, s, a, c, d) => {
                d = d || !!t.dynamicChildren;
                const p = t.children,
                    f = p.length;
                let h = !1;
                for (let t = 0; t < f; t++) {
                    const m = d ? p[t] : (p[t] = Va(p[t])),
                        g = m.type === ma;
                    e
                        ? (g &&
                              !d &&
                              t + 1 < f &&
                              Va(p[t + 1]).type === ma &&
                              (l(o(e.data.slice(m.children.length)), r, i(e)), (e.data = m.children)),
                          (e = u(e, m, s, a, c, d)))
                        : g && !m.children
                          ? l((m.el = o('')), r)
                          : (So(r, 1) ||
                                (h ||
                                    (En(
                                        'Hydration children mismatch on',
                                        r,
                                        '\nServer rendered element contains fewer child nodes than client vdom.'
                                    ),
                                    (h = !0)),
                                uo()),
                            n(null, m, r, null, s, a, po(r), c));
                }
                return e;
            },
            h = (e, t, n, r, o, a) => {
                const { slotScopeIds: c } = t;
                c && (o = o ? o.concat(c) : c);
                const u = s(e),
                    p = f(i(e), t, u, n, r, o, a);
                return p && fo(p) && ']' === p.data ? i((t.anchor = p)) : (uo(), l((t.anchor = d(']')), u, p), p);
            },
            m = (e, t, r, o, l, c) => {
                if (
                    (So(e.parentElement, 1) ||
                        (En(
                            'Hydration node mismatch:\n- rendered on server:',
                            e,
                            3 === e.nodeType ? '(text)' : fo(e) && '[' === e.data ? '(start of fragment)' : '',
                            '\n- expected on client:',
                            t.type
                        ),
                        uo()),
                    (t.el = null),
                    c)
                ) {
                    const t = g(e);
                    for (;;) {
                        const n = i(e);
                        if (!n || n === t) break;
                        a(n);
                    }
                }
                const d = i(e),
                    u = s(e);
                return (a(e), n(null, t, u, d, r, o, po(u), l), r && ((r.vnode.el = t.el), Ss(r, t.el)), d);
            },
            g = (e, t = '[', n = ']') => {
                let r = 0;
                for (; e; )
                    if ((e = i(e)) && fo(e) && (e.data === t && r++, e.data === n)) {
                        if (0 === r) return i(e);
                        r--;
                    }
                return e;
            },
            v = (e, t, n) => {
                const r = t.parentNode;
                r && r.replaceChild(e, t);
                let o = n;
                for (; o; ) (o.vnode.el === t && (o.vnode.el = o.subTree.el = e), (o = o.parent));
            },
            y = e => 1 === e.nodeType && 'TEMPLATE' === e.tagName;
        return [
            (e, t) => {
                if (!t.hasChildNodes())
                    return (
                        En(
                            'Attempting to hydrate existing markup but container is empty. Performing full mount instead.'
                        ),
                        n(null, e, t),
                        Kn(),
                        void (t._vnode = e)
                    );
                (u(t.firstChild, e, null, null, null), Kn(), (t._vnode = e));
            },
            u
        ];
    }
    function mo(e, t, n, r, o) {
        let i, s, a, l;
        if ('class' === t)
            (e.$cls ? ((a = e.$cls), delete e.$cls) : (a = e.getAttribute('class')),
                (l = Z(n)),
                (function (e, t) {
                    if (e.size !== t.size) return !1;
                    for (const n of e) if (!t.has(n)) return !1;
                    return !0;
                })(go(a || ''), go(l)) || ((i = 2), (s = 'class')));
        else if ('style' === t) {
            ((a = e.getAttribute('style') || ''),
                (l = w(n)
                    ? n
                    : (function (e) {
                          if (!e) return '';
                          if (w(e)) return e;
                          let t = '';
                          for (const n in e) {
                              const r = e[n];
                              (w(r) || 'number' == typeof r) && (t += `${n.startsWith('--') ? n : R(n)}:${r};`);
                          }
                          return t;
                      })(Y(n))));
            const t = vo(a),
                c = vo(l);
            if (r.dirs) for (const { dir: e, value: t } of r.dirs) 'show' !== e.name || t || c.set('display', 'none');
            (o && yo(o, r, c),
                (function (e, t) {
                    if (e.size !== t.size) return !1;
                    for (const [n, r] of e) if (r !== t.get(n)) return !1;
                    return !0;
                })(t, c) || ((i = 3), (s = 'style')));
        } else
            ((e instanceof SVGElement && de(t)) || (e instanceof HTMLElement && (ae(t) || ce(t)))) &&
                (ae(t)
                    ? ((a = e.hasAttribute(t)), (l = le(n)))
                    : null == n
                      ? ((a = e.hasAttribute(t)), (l = !1))
                      : ((a = e.hasAttribute(t)
                            ? e.getAttribute(t)
                            : 'value' === t && 'TEXTAREA' === e.tagName && e.value),
                        (l =
                            !!(function (e) {
                                if (null == e) return !1;
                                const t = typeof e;
                                return 'string' === t || 'number' === t || 'boolean' === t;
                            })(n) && String(n))),
                a !== l && ((i = 4), (s = t)));
        if (null != i && !So(e, i)) {
            const t = e => (!1 === e ? '(not rendered)' : `${s}="${e}"`);
            return (
                En(
                    `Hydration ${wo[i]} mismatch on`,
                    e,
                    `\n  - rendered on server: ${t(a)}\n  - expected on client: ${t(l)}\n  Note: this mismatch is check-only. The DOM will not be rectified in production due to performance overhead.\n  You should fix the source of the mismatch.`
                ),
                !0
            );
        }
        return !1;
    }
    function go(e) {
        return new Set(e.trim().split(/\s+/));
    }
    function vo(e) {
        const t = new Map();
        for (const n of e.split(';')) {
            let [e, r] = n.split(':');
            ((e = e.trim()), (r = r && r.trim()), e && r && t.set(e, r));
        }
        return t;
    }
    function yo(e, t, n) {
        const r = e.subTree;
        if (e.getCssVars && (t === r || (r && r.type === ha && r.children.includes(t)))) {
            const t = e.getCssVars();
            for (const e in t) {
                const r = be(t[e]);
                n.set(`--${pe(e, !1)}`, r);
            }
        }
        t === r && e.parent && yo(e.parent, e.vnode, n);
    }
    const bo = 'data-allow-mismatch',
        wo = { 0: 'text', 1: 'children', 2: 'class', 3: 'style', 4: 'attribute' };
    function So(e, t) {
        if (0 === t || 1 === t) for (; e && !e.hasAttribute(bo); ) e = e.parentElement;
        const n = e && e.getAttribute(bo);
        if (null == n) return !1;
        if ('' === n) return !0;
        {
            const e = n.split(',');
            return !(0 !== t || !e.includes('children')) || e.includes(wo[t]);
        }
    }
    const xo = U().requestIdleCallback || (e => setTimeout(e, 1)),
        _o = U().cancelIdleCallback || (e => clearTimeout(e)),
        To =
            (e = 1e4) =>
            t => {
                const n = xo(t, { timeout: e });
                return () => _o(n);
            },
        Co = e => (t, n) => {
            const r = new IntersectionObserver(e => {
                for (const n of e)
                    if (n.isIntersecting) {
                        (r.disconnect(), t());
                        break;
                    }
            }, e);
            return (
                n(e => {
                    if (e instanceof Element)
                        return (function (e) {
                            const { top: t, left: n, bottom: r, right: o } = e.getBoundingClientRect(),
                                { innerHeight: i, innerWidth: s } = window;
                            return ((t > 0 && t < i) || (r > 0 && r < i)) && ((n > 0 && n < s) || (o > 0 && o < s));
                        })(e)
                            ? (t(), r.disconnect(), !1)
                            : void r.observe(e);
                }),
                () => r.disconnect()
            );
        },
        ko = e => t => {
            if (e) {
                const n = matchMedia(e);
                if (!n.matches)
                    return (n.addEventListener('change', t, { once: !0 }), () => n.removeEventListener('change', t));
                t();
            }
        },
        Eo =
            (e = []) =>
            (t, n) => {
                w(e) && (e = [e]);
                let r = !1;
                const o = e => {
                        r || ((r = !0), i(), t(), e.target.dispatchEvent(new e.constructor(e.type, e)));
                    },
                    i = () => {
                        n(t => {
                            for (const n of e) t.removeEventListener(n, o);
                        });
                    };
                return (
                    n(t => {
                        for (const n of e) t.addEventListener(n, o, { once: !0 });
                    }),
                    i
                );
            },
        Ao = e => !!e.type.__asyncLoader;
    function Oo(e) {
        b(e) && (e = { loader: e });
        const {
            loader: t,
            loadingComponent: n,
            errorComponent: r,
            delay: o = 200,
            hydrate: i,
            timeout: s,
            suspensible: a = !0,
            onError: l
        } = e;
        let c,
            d = null,
            u = 0;
        const p = () => {
            let e;
            return (
                d ||
                (e = d =
                    t()
                        .catch(e => {
                            if (((e = e instanceof Error ? e : new Error(String(e))), l))
                                return new Promise((t, n) => {
                                    l(
                                        e,
                                        () => t((u++, (d = null), p())),
                                        () => n(e),
                                        u + 1
                                    );
                                });
                            throw e;
                        })
                        .then(t => {
                            if (e !== d && d) return d;
                            if (
                                (t ||
                                    En(
                                        'Async component loader resolved to undefined. If you are using retry(), make sure to return its return value.'
                                    ),
                                t && (t.__esModule || 'Module' === t[Symbol.toStringTag]) && (t = t.default),
                                t && !x(t) && !b(t))
                            )
                                throw new Error(`Invalid async component load result: ${t}`);
                            return ((c = t), t);
                        }))
            );
        };
        return to({
            name: 'AsyncComponentWrapper',
            __asyncLoader: p,
            __asyncHydrate(e, t, n) {
                let r = !1;
                (t.bu || (t.bu = [])).push(() => (r = !0));
                const o = () => {
                        r
                            ? En(
                                  `Skipping lazy hydration for component '${vl(c) || c.__file}': it was updated before lazy hydration performed.`
                              )
                            : n();
                    },
                    s = i
                        ? () => {
                              const n = i(o, t =>
                                  (function (e, t) {
                                      if (fo(e) && '[' === e.data) {
                                          let n = 1,
                                              r = e.nextSibling;
                                          for (; r; ) {
                                              if (1 === r.nodeType) {
                                                  if (!1 === t(r)) break;
                                              } else if (fo(r))
                                                  if (']' === r.data) {
                                                      if (0 === --n) break;
                                                  } else '[' === r.data && n++;
                                              r = r.nextSibling;
                                          }
                                      } else t(e);
                                  })(e, t)
                              );
                              n && (t.bum || (t.bum = [])).push(n);
                          }
                        : o;
                c ? s() : p().then(() => !t.isUnmounted && s());
            },
            get __asyncResolved() {
                return c;
            },
            setup() {
                const e = Ka;
                if ((ro(e), c)) return () => Io(c, e);
                const t = t => {
                    ((d = null), Rn(t, e, 13, !r));
                };
                if ((a && e.suspense) || sl)
                    return p()
                        .then(t => () => Io(t, e))
                        .catch(e => (t(e), () => (r ? La(r, { error: e }) : null)));
                const i = Jt(!1),
                    l = Jt(),
                    u = Jt(!!o);
                return (
                    o &&
                        setTimeout(() => {
                            u.value = !1;
                        }, o),
                    null != s &&
                        setTimeout(() => {
                            if (!i.value && !l.value) {
                                const e = new Error(`Async component timed out after ${s}ms.`);
                                (t(e), (l.value = e));
                            }
                        }, s),
                    p()
                        .then(() => {
                            ((i.value = !0), e.parent && Mo(e.parent.vnode) && e.parent.update());
                        })
                        .catch(e => {
                            (t(e), (l.value = e));
                        }),
                    () =>
                        i.value && c
                            ? Io(c, e)
                            : l.value && r
                              ? La(r, { error: l.value })
                              : n && !u.value
                                ? Io(n, e)
                                : void 0
                );
            }
        });
    }
    function Io(e, t) {
        const { ref: n, props: r, children: o, ce: i } = t.vnode,
            s = La(e, r, o);
        return ((s.ref = n), (s.ce = i), delete t.vnode.ce, s);
    }
    const Mo = e => e.type.__isKeepAlive,
        Po = {
            name: 'KeepAlive',
            __isKeepAlive: !0,
            props: { include: [String, RegExp, Array], exclude: [String, RegExp, Array], max: [String, Number] },
            setup(e, { slots: t }) {
                const n = Xa(),
                    r = n.ctx;
                if (!r.renderer)
                    return () => {
                        const e = t.default && t.default();
                        return e && 1 === e.length ? e[0] : e;
                    };
                const o = new Map(),
                    i = new Set();
                let s = null;
                n.__v_cache = o;
                const a = n.suspense,
                    {
                        renderer: {
                            p: l,
                            m: c,
                            um: d,
                            o: { createElement: u }
                        }
                    } = r,
                    p = u('div');
                function f(e) {
                    (Fo(e), d(e, n, a, !0));
                }
                function h(e) {
                    o.forEach((t, n) => {
                        const r = vl(t.type);
                        r && !e(r) && m(n);
                    });
                }
                function m(e) {
                    const t = o.get(e);
                    (!t || (s && Oa(t, s)) ? s && Fo(s) : f(t), o.delete(e), i.delete(e));
                }
                ((r.activate = (e, t, n, r, o) => {
                    const i = e.component;
                    (c(e, t, n, 0, a),
                        l(i.vnode, e, t, n, i, a, r, e.slotScopeIds, o),
                        Ks(() => {
                            ((i.isDeactivated = !1), i.a && D(i.a));
                            const t = e.props && e.props.onVnodeMounted;
                            t && qa(t, i.parent, e);
                        }, a),
                        ur(i));
                }),
                    (r.deactivate = e => {
                        const t = e.component;
                        (oa(t.m),
                            oa(t.a),
                            c(e, p, null, 1, a),
                            Ks(() => {
                                t.da && D(t.da);
                                const n = e.props && e.props.onVnodeUnmounted;
                                (n && qa(n, t.parent, e), (t.isDeactivated = !0));
                            }, a),
                            ur(t),
                            (t.__keepAliveStorageContainer = p));
                    }),
                    ns(
                        () => [e.include, e.exclude],
                        ([e, t]) => {
                            (e && h(t => No(e, t)), t && h(e => !No(t, e)));
                        },
                        { flush: 'post', deep: !0 }
                    ));
                let g = null;
                const v = () => {
                    null != g &&
                        (ia(n.subTree.type)
                            ? Ks(() => {
                                  o.set(g, Do(n.subTree));
                              }, n.subTree.suspense)
                            : o.set(g, Do(n.subTree)));
                };
                return (
                    Ho(v),
                    qo(v),
                    Wo(() => {
                        o.forEach(e => {
                            const { subTree: t, suspense: r } = n,
                                o = Do(t);
                            if (e.type === o.type && e.key === o.key) {
                                Fo(o);
                                const e = o.component.da;
                                return void (e && Ks(e, r));
                            }
                            f(e);
                        });
                    }),
                    () => {
                        if (((g = null), !t.default)) return (s = null);
                        const n = t.default(),
                            r = n[0];
                        if (n.length > 1)
                            return (En('KeepAlive should contain exactly one component child.'), (s = null), n);
                        if (!Aa(r) || !(4 & r.shapeFlag || 128 & r.shapeFlag)) return ((s = null), r);
                        let a = Do(r);
                        if (a.type === ga) return ((s = null), a);
                        const l = a.type,
                            c = vl(Ao(a) ? a.type.__asyncResolved || {} : l),
                            { include: d, exclude: u, max: p } = e;
                        if ((d && (!c || !No(d, c))) || (u && c && No(u, c)))
                            return ((a.shapeFlag &= -257), (s = a), r);
                        const f = null == a.key ? l : a.key,
                            h = o.get(f);
                        return (
                            a.el && ((a = $a(a)), 128 & r.shapeFlag && (r.ssContent = a)),
                            (g = f),
                            h
                                ? ((a.el = h.el),
                                  (a.component = h.component),
                                  a.transition && Zr(a, a.transition),
                                  (a.shapeFlag |= 512),
                                  i.delete(f),
                                  i.add(f))
                                : (i.add(f), p && i.size > parseInt(p, 10) && m(i.values().next().value)),
                            (a.shapeFlag |= 256),
                            (s = a),
                            ia(r.type) ? r : a
                        );
                    }
                );
            }
        };
    function No(e, t) {
        return m(e)
            ? e.some(e => No(e, t))
            : w(e)
              ? e.split(',').includes(t)
              : '[object RegExp]' === C(e) && ((e.lastIndex = 0), e.test(t));
    }
    function Lo(e, t) {
        $o(e, 'a', t);
    }
    function Ro(e, t) {
        $o(e, 'da', t);
    }
    function $o(e, t, n = Ka) {
        const r =
            e.__wdc ||
            (e.__wdc = () => {
                let t = n;
                for (; t; ) {
                    if (t.isDeactivated) return;
                    t = t.parent;
                }
                return e();
            });
        if ((jo(t, r, n), n)) {
            let e = n.parent;
            for (; e && e.parent; ) (Mo(e.parent.vnode) && Bo(r, t, n, e), (e = e.parent));
        }
    }
    function Bo(e, t, n, r) {
        const o = jo(t, e, r, !0);
        Go(() => {
            p(r[t], o);
        }, n);
    }
    function Fo(e) {
        ((e.shapeFlag &= -257), (e.shapeFlag &= -513));
    }
    function Do(e) {
        return 128 & e.shapeFlag ? e.ssContent : e;
    }
    function jo(e, t, n = Ka, r = !1) {
        if (n) {
            const o = n[e] || (n[e] = []),
                i =
                    t.__weh ||
                    (t.__weh = (...r) => {
                        qe();
                        const o = Za(n),
                            i = Ln(t, n, e, r);
                        return (o(), We(), i);
                    });
            return (r ? o.unshift(i) : o.push(i), i);
        }
        En(
            `${B(Pn[e].replace(/ hook$/, ''))} is called when there is no active component instance to be associated with. Lifecycle injection APIs can only be used during execution of setup(). If you are using async setup(), make sure to register lifecycle hooks before the first await statement.`
        );
    }
    const Vo =
            e =>
            (t, n = Ka) => {
                (sl && 'sp' !== e) || jo(e, (...e) => t(...e), n);
            },
        zo = Vo('bm'),
        Ho = Vo('m'),
        Uo = Vo('bu'),
        qo = Vo('u'),
        Wo = Vo('bum'),
        Go = Vo('um'),
        Yo = Vo('sp'),
        Ko = Vo('rtg'),
        Xo = Vo('rtc');
    function Jo(e, t = Ka) {
        jo('ec', e, t);
    }
    const Qo = 'components',
        Zo = 'directives';
    function ei(e, t) {
        return oi(Qo, e, !0, t) || e;
    }
    const ti = Symbol.for('v-ndc');
    function ni(e) {
        return w(e) ? oi(Qo, e, !1) || e : e || ti;
    }
    function ri(e) {
        return oi(Zo, e);
    }
    function oi(e, t, n = !0, r = !1) {
        const o = br || Ka;
        if (o) {
            const i = o.type;
            if (e === Qo) {
                const e = vl(i, !1);
                if (e && (e === t || e === N(t) || e === $(N(t)))) return i;
            }
            const s = ii(o[e] || i[e], t) || ii(o.appContext[e], t);
            if (!s && r) return i;
            if (n && !s) {
                const n =
                    e === Qo
                        ? '\nIf this is a native custom element, make sure to exclude it from component resolution via compilerOptions.isCustomElement.'
                        : '';
                En(`Failed to resolve ${e.slice(0, -1)}: ${t}${n}`);
            }
            return s;
        }
        En(`resolve${$(e.slice(0, -1))} can only be used in render() or setup().`);
    }
    function ii(e, t) {
        return e && (e[t] || e[N(t)] || e[$(N(t))]);
    }
    function si(e, t, n, r) {
        let o;
        const i = n && n[r],
            s = m(e);
        if (s || w(e)) {
            let n = !1,
                r = !1;
            (s && zt(e) && ((n = !Ut(e)), (r = Ht(e)), (e = it(e))), (o = new Array(e.length)));
            for (let s = 0, a = e.length; s < a; s++)
                o[s] = t(n ? (r ? Kt(Yt(e[s])) : Yt(e[s])) : e[s], s, void 0, i && i[s]);
        } else if ('number' == typeof e) {
            (Number.isInteger(e) || En(`The v-for range expect an integer value but got ${e}.`), (o = new Array(e)));
            for (let n = 0; n < e; n++) o[n] = t(n + 1, n, void 0, i && i[n]);
        } else if (x(e))
            if (e[Symbol.iterator]) o = Array.from(e, (e, n) => t(e, n, void 0, i && i[n]));
            else {
                const n = Object.keys(e);
                o = new Array(n.length);
                for (let r = 0, s = n.length; r < s; r++) {
                    const s = n[r];
                    o[r] = t(e[s], s, r, i && i[r]);
                }
            }
        else o = [];
        return (n && (n[r] = o), o);
    }
    function ai(e, t) {
        for (let n = 0; n < t.length; n++) {
            const r = t[n];
            if (m(r)) for (let t = 0; t < r.length; t++) e[r[t].name] = r[t].fn;
            else
                r &&
                    (e[r.name] = r.key
                        ? (...e) => {
                              const t = r.fn(...e);
                              return (t && (t.key = r.key), t);
                          }
                        : r.fn);
        }
        return e;
    }
    function li(e, t, n = {}, r, o) {
        if (br.ce || (br.parent && Ao(br.parent) && br.parent.ce)) {
            const e = Object.keys(n).length > 0;
            return ('default' !== t && (n.name = t), wa(), Ea(ha, null, [La('slot', n, r && r())], e ? -2 : 64));
        }
        let i = e[t];
        (i &&
            i.length > 1 &&
            (En(
                'SSR-optimized slot function detected in a non-SSR-optimized render function. You need to mark this component with $dynamic-slots in the parent template.'
            ),
            (i = () => [])),
            i && i._c && (i._d = !1),
            wa());
        const s = i && ci(i(n)),
            a = n.key || (s && s.key),
            l = Ea(
                ha,
                { key: (a && !S(a) ? a : `_${t}`) + (!s && r ? '_fb' : '') },
                s || (r ? r() : []),
                s && 1 === e._ ? 64 : -2
            );
        return (!o && l.scopeId && (l.slotScopeIds = [l.scopeId + '-s']), i && i._c && (i._d = !0), l);
    }
    function ci(e) {
        return e.some(e => !Aa(e) || (e.type !== ga && !(e.type === ha && !ci(e.children)))) ? e : null;
    }
    function di(e, t) {
        const n = {};
        if (!x(e)) return (En('v-on with no argument expects an object value.'), n);
        for (const r in e) n[t && /[A-Z]/.test(r) ? `on:${r}` : B(r)] = e[r];
        return n;
    }
    const ui = e => (e ? (rl(e) ? hl(e) : ui(e.parent)) : null),
        pi = u(Object.create(null), {
            $: e => e,
            $el: e => e.vnode.el,
            $data: e => e.data,
            $props: e => jt(e.props),
            $attrs: e => jt(e.attrs),
            $slots: e => jt(e.slots),
            $refs: e => jt(e.refs),
            $parent: e => ui(e.parent),
            $root: e => ui(e.root),
            $host: e => e.ce,
            $emit: e => e.emit,
            $options: e => $i(e),
            $forceUpdate: e =>
                e.f ||
                (e.f = () => {
                    qn(e.update);
                }),
            $nextTick: e => e.n || (e.n = Un.bind(e.proxy)),
            $watch: e => os.bind(e)
        }),
        fi = e => '_' === e || '$' === e,
        hi = (e, t) => e !== i && !e.__isScriptSetup && h(e, t),
        mi = {
            get({ _: e }, t) {
                if ('__v_skip' === t) return !0;
                const { ctx: n, setupState: r, data: o, props: s, accessCache: a, type: l, appContext: c } = e;
                if ('__isVue' === t) return !0;
                if ('$' !== t[0]) {
                    const e = a[t];
                    if (void 0 !== e)
                        switch (e) {
                            case 1:
                                return r[t];
                            case 2:
                                return o[t];
                            case 4:
                                return n[t];
                            case 3:
                                return s[t];
                        }
                    else {
                        if (hi(r, t)) return ((a[t] = 1), r[t]);
                        if (o !== i && h(o, t)) return ((a[t] = 2), o[t]);
                        if (h(s, t)) return ((a[t] = 3), s[t]);
                        if (n !== i && h(n, t)) return ((a[t] = 4), n[t]);
                        Ni && (a[t] = 0);
                    }
                }
                const d = pi[t];
                let u, p;
                return d
                    ? ('$attrs' === t ? (nt(e.attrs, 'get', ''), fs()) : '$slots' === t && nt(e, 'get', t), d(e))
                    : (u = l.__cssModules) && (u = u[t])
                      ? u
                      : n !== i && h(n, t)
                        ? ((a[t] = 4), n[t])
                        : ((p = c.config.globalProperties),
                          h(p, t)
                              ? p[t]
                              : void (
                                    !br ||
                                    (w(t) && 0 === t.indexOf('__v')) ||
                                    (o !== i && fi(t[0]) && h(o, t)
                                        ? En(
                                              `Property ${JSON.stringify(t)} must be accessed via $data because it starts with a reserved character ("$" or "_") and is not proxied on the render context.`
                                          )
                                        : e === br &&
                                          En(
                                              `Property ${JSON.stringify(t)} was accessed during render but is not defined on instance.`
                                          ))
                                ));
            },
            set({ _: e }, t, n) {
                const { data: r, setupState: o, ctx: s } = e;
                return hi(o, t)
                    ? ((o[t] = n), !0)
                    : o.__isScriptSetup && h(o, t)
                      ? (En(`Cannot mutate <script setup> binding "${t}" from Options API.`), !1)
                      : r !== i && h(r, t)
                        ? ((r[t] = n), !0)
                        : h(e.props, t)
                          ? (En(`Attempting to mutate prop "${t}". Props are readonly.`), !1)
                          : '$' === t[0] && t.slice(1) in e
                            ? (En(
                                  `Attempting to mutate public property "${t}". Properties starting with $ are reserved and readonly.`
                              ),
                              !1)
                            : (t in e.appContext.config.globalProperties
                                  ? Object.defineProperty(s, t, { enumerable: !0, configurable: !0, value: n })
                                  : (s[t] = n),
                              !0);
            },
            has({ _: { data: e, setupState: t, accessCache: n, ctx: r, appContext: o, props: s, type: a } }, l) {
                let c;
                return !!(
                    n[l] ||
                    (e !== i && '$' !== l[0] && h(e, l)) ||
                    hi(t, l) ||
                    h(s, l) ||
                    h(r, l) ||
                    h(pi, l) ||
                    h(o.config.globalProperties, l) ||
                    ((c = a.__cssModules) && c[l])
                );
            },
            defineProperty(e, t, n) {
                return (
                    null != n.get ? (e._.accessCache[t] = 0) : h(n, 'value') && this.set(e, t, n.value, null),
                    Reflect.defineProperty(e, t, n)
                );
            },
            ownKeys: e => (
                En(
                    'Avoid app logic that relies on enumerating keys on a component instance. The keys will be empty in production mode to avoid performance overhead.'
                ),
                Reflect.ownKeys(e)
            )
        },
        gi = u({}, mi, {
            get(e, t) {
                if (t !== Symbol.unscopables) return mi.get(e, t, e);
            },
            has(e, t) {
                const n = '_' !== t[0] && !G(t);
                return (
                    !n &&
                        mi.has(e, t) &&
                        En(
                            `Property ${JSON.stringify(t)} should not start with _ which is a reserved prefix for Vue internals.`
                        ),
                    n
                );
            }
        }),
        vi = e =>
            En(
                `${e}() is a compiler-hint helper that is only usable inside <script setup> of a single file component. Its arguments should be compiled away and passing it at runtime has no effect.`
            );
    function yi() {
        return (vi('defineProps'), null);
    }
    function bi() {
        return (vi('defineEmits'), null);
    }
    function wi(e) {
        vi('defineExpose');
    }
    function Si(e) {
        vi('defineOptions');
    }
    function xi() {
        return (vi('defineSlots'), null);
    }
    function _i() {
        vi('defineModel');
    }
    function Ti(e, t) {
        return (vi('withDefaults'), null);
    }
    function Ci() {
        return Ei('useSlots').slots;
    }
    function ki() {
        return Ei('useAttrs').attrs;
    }
    function Ei(e) {
        const t = Xa();
        return (t || En(`${e}() called without active instance.`), t.setupContext || (t.setupContext = fl(t)));
    }
    function Ai(e) {
        return m(e) ? e.reduce((e, t) => ((e[t] = null), e), {}) : e;
    }
    function Oi(e, t) {
        const n = Ai(e);
        for (const e in t) {
            if (e.startsWith('__skip')) continue;
            let r = n[e];
            (r
                ? m(r) || b(r)
                    ? (r = n[e] = { type: r, default: t[e] })
                    : (r.default = t[e])
                : null === r
                  ? (r = n[e] = { default: t[e] })
                  : En(`props default key "${e}" has no corresponding declaration.`),
                r && t[`__skip_${e}`] && (r.skipFactory = !0));
        }
        return n;
    }
    function Ii(e, t) {
        return e && t ? (m(e) && m(t) ? e.concat(t) : u({}, Ai(e), Ai(t))) : e || t;
    }
    function Mi(e, t) {
        const n = {};
        for (const r in e) t.includes(r) || Object.defineProperty(n, r, { enumerable: !0, get: () => e[r] });
        return n;
    }
    function Pi(e) {
        const t = Xa();
        t || En('withAsyncContext called without active current instance. This is likely a bug.');
        let n = e();
        return (
            el(),
            _(n) &&
                (n = n.catch(e => {
                    throw (Za(t), e);
                })),
            [n, () => Za(t)]
        );
    }
    let Ni = !0;
    function Li(e, t, n) {
        Ln(m(e) ? e.map(e => e.bind(t.proxy)) : e.bind(t.proxy), t, n);
    }
    function Ri(e, t, n, r) {
        let o = r.includes('.') ? is(n, r) : () => n[r];
        if (w(e)) {
            const n = t[e];
            b(n) ? ns(o, n) : En(`Invalid watch handler specified by key "${e}"`, n);
        } else if (b(e)) ns(o, e.bind(n));
        else if (x(e))
            if (m(e)) e.forEach(e => Ri(e, t, n, r));
            else {
                const r = b(e.handler) ? e.handler.bind(n) : t[e.handler];
                b(r) ? ns(o, r, e) : En(`Invalid watch handler specified by key "${e.handler}"`, r);
            }
        else En(`Invalid watch option: "${r}"`, e);
    }
    function $i(e) {
        const t = e.type,
            { mixins: n, extends: r } = t,
            {
                mixins: o,
                optionsCache: i,
                config: { optionMergeStrategies: s }
            } = e.appContext,
            a = i.get(t);
        let l;
        return (
            a
                ? (l = a)
                : o.length || n || r
                  ? ((l = {}), o.length && o.forEach(e => Bi(l, e, s, !0)), Bi(l, t, s))
                  : (l = t),
            x(t) && i.set(t, l),
            l
        );
    }
    function Bi(e, t, n, r = !1) {
        const { mixins: o, extends: i } = t;
        (i && Bi(e, i, n, !0), o && o.forEach(t => Bi(e, t, n, !0)));
        for (const o in t)
            if (r && 'expose' === o)
                En(
                    '"expose" option is ignored when declared in mixins or extends. It should only be declared in the base component itself.'
                );
            else {
                const r = Fi[o] || (n && n[o]);
                e[o] = r ? r(e[o], t[o]) : t[o];
            }
        return e;
    }
    const Fi = {
        data: Di,
        props: Hi,
        emits: Hi,
        methods: zi,
        computed: zi,
        beforeCreate: Vi,
        created: Vi,
        beforeMount: Vi,
        mounted: Vi,
        beforeUpdate: Vi,
        updated: Vi,
        beforeDestroy: Vi,
        beforeUnmount: Vi,
        destroyed: Vi,
        unmounted: Vi,
        activated: Vi,
        deactivated: Vi,
        errorCaptured: Vi,
        serverPrefetch: Vi,
        components: zi,
        directives: zi,
        watch: function (e, t) {
            if (!e) return t;
            if (!t) return e;
            const n = u(Object.create(null), e);
            for (const r in t) n[r] = Vi(e[r], t[r]);
            return n;
        },
        provide: Di,
        inject: function (e, t) {
            return zi(ji(e), ji(t));
        }
    };
    function Di(e, t) {
        return t
            ? e
                ? function () {
                      return u(b(e) ? e.call(this, this) : e, b(t) ? t.call(this, this) : t);
                  }
                : t
            : e;
    }
    function ji(e) {
        if (m(e)) {
            const t = {};
            for (let n = 0; n < e.length; n++) t[e[n]] = e[n];
            return t;
        }
        return e;
    }
    function Vi(e, t) {
        return e ? [...new Set([].concat(e, t))] : t;
    }
    function zi(e, t) {
        return e ? u(Object.create(null), e, t) : t;
    }
    function Hi(e, t) {
        return e
            ? m(e) && m(t)
                ? [...new Set([...e, ...t])]
                : u(Object.create(null), Ai(e), Ai(null != t ? t : {}))
            : t;
    }
    function Ui() {
        return {
            app: null,
            config: {
                isNativeTag: l,
                performance: !1,
                globalProperties: {},
                optionMergeStrategies: {},
                errorHandler: void 0,
                warnHandler: void 0,
                compilerOptions: {}
            },
            mixins: [],
            components: {},
            directives: {},
            provides: Object.create(null),
            optionsCache: new WeakMap(),
            propsCache: new WeakMap(),
            emitsCache: new WeakMap()
        };
    }
    let qi = 0;
    function Wi(e, t) {
        return function (n, r = null) {
            (b(n) || (n = u({}, n)),
                null == r || x(r) || (En('root props passed to app.mount() must be an object.'), (r = null)));
            const o = Ui(),
                i = new WeakSet(),
                s = [];
            let a = !1;
            const l = (o.app = {
                _uid: qi++,
                _component: n,
                _props: r,
                _container: null,
                _context: o,
                _instance: null,
                version: Cl,
                get config() {
                    return o.config;
                },
                set config(e) {
                    En('app.config cannot be replaced. Modify individual options instead.');
                },
                use: (e, ...t) => (
                    i.has(e)
                        ? En('Plugin has already been applied to target app.')
                        : e && b(e.install)
                          ? (i.add(e), e.install(l, ...t))
                          : b(e)
                            ? (i.add(e), e(l, ...t))
                            : En('A plugin must either be a function or an object with an "install" function.'),
                    l
                ),
                mixin: e => (
                    o.mixins.includes(e)
                        ? En('Mixin has already been applied to target app' + (e.name ? `: ${e.name}` : ''))
                        : o.mixins.push(e),
                    l
                ),
                component: (e, t) => (
                    nl(e, o.config),
                    t
                        ? (o.components[e] && En(`Component "${e}" has already been registered in target app.`),
                          (o.components[e] = t),
                          l)
                        : o.components[e]
                ),
                directive: (e, t) => (
                    kr(e),
                    t
                        ? (o.directives[e] && En(`Directive "${e}" has already been registered in target app.`),
                          (o.directives[e] = t),
                          l)
                        : o.directives[e]
                ),
                mount(i, s, c) {
                    if (!a) {
                        i.__vue_app__ &&
                            En(
                                'There is already an app instance mounted on the host container.\n If you want to mount another app on the same host container, you need to unmount the previous app by calling `app.unmount()` first.'
                            );
                        const d = l._ceVNode || La(n, r);
                        return (
                            (d.appContext = o),
                            !0 === c ? (c = 'svg') : !1 === c && (c = void 0),
                            (o.reload = () => {
                                const t = $a(d);
                                ((t.el = null), e(t, i, c));
                            }),
                            s && t ? t(d, i) : e(d, i, c),
                            (a = !0),
                            (l._container = i),
                            (i.__vue_app__ = l),
                            (l._instance = d.component),
                            (function (e, t) {
                                cr('app:init', e, t, { Fragment: ha, Text: ma, Comment: ga, Static: va });
                            })(l, Cl),
                            hl(d.component)
                        );
                    }
                    En(
                        'App has already been mounted.\nIf you want to remount the same app, move your app creation logic into a factory function and create fresh app instances for each mount - e.g. `const createMyApp = () => createApp(App)`'
                    );
                },
                onUnmount(e) {
                    ('function' != typeof e &&
                        En('Expected function as first argument to app.onUnmount(), but got ' + typeof e),
                        s.push(e));
                },
                unmount() {
                    a
                        ? (Ln(s, l._instance, 16),
                          e(null, l._container),
                          (l._instance = null),
                          (function (e) {
                              cr('app:unmount', e);
                          })(l),
                          delete l._container.__vue_app__)
                        : En('Cannot unmount an app that is not mounted.');
                },
                provide: (e, t) => (
                    e in o.provides &&
                        (h(o.provides, e)
                            ? En(
                                  `App already provides property with key "${String(e)}". It will be overwritten with the new value.`
                              )
                            : En(
                                  `App already provides property with key "${String(e)}" inherited from its parent element. It will be overwritten with the new value.`
                              )),
                    (o.provides[e] = t),
                    l
                ),
                runWithContext(e) {
                    const t = Gi;
                    Gi = l;
                    try {
                        return e();
                    } finally {
                        Gi = t;
                    }
                }
            });
            return l;
        };
    }
    let Gi = null;
    function Yi(e, t) {
        if (((Ka && !Ka.isMounted) || En('provide() can only be used inside setup().'), Ka)) {
            let n = Ka.provides;
            const r = Ka.parent && Ka.parent.provides;
            (r === n && (n = Ka.provides = Object.create(r)), (n[e] = t));
        }
    }
    function Ki(e, t, n = !1) {
        const r = Xa();
        if (r || Gi) {
            let o = Gi
                ? Gi._context.provides
                : r
                  ? null == r.parent || r.ce
                      ? r.vnode.appContext && r.vnode.appContext.provides
                      : r.parent.provides
                  : void 0;
            if (o && e in o) return o[e];
            if (arguments.length > 1) return n && b(t) ? t.call(r && r.proxy) : t;
            En(`injection "${String(e)}" not found.`);
        } else En('inject() can only be used inside setup() or functional components.');
    }
    function Xi() {
        return !(!Xa() && !Gi);
    }
    const Ji = Symbol.for('v-scx'),
        Qi = () => {
            {
                const e = Ki(Ji);
                return (
                    e ||
                        En(
                            'Server rendering context not provided. Make sure to only call useSSRContext() conditionally in the server build.'
                        ),
                    e
                );
            }
        };
    function Zi(e, t) {
        return rs(e, null, t);
    }
    function es(e, t) {
        return rs(e, null, u({}, t, { flush: 'post' }));
    }
    function ts(e, t) {
        return rs(e, null, u({}, t, { flush: 'sync' }));
    }
    function ns(e, t, n) {
        return (
            b(t) ||
                En(
                    '`watch(fn, options?)` signature has been moved to a separate API. Use `watchEffect(fn, options?)` instead. `watch` now only supports `watch(source, cb, options?) signature.'
                ),
            rs(e, t, n)
        );
    }
    function rs(e, t, n = i) {
        const { immediate: r, deep: o, flush: s, once: l } = n;
        t ||
            (void 0 !== r &&
                En(
                    'watch() "immediate" option is only respected when using the watch(source, callback, options?) signature.'
                ),
            void 0 !== o &&
                En(
                    'watch() "deep" option is only respected when using the watch(source, callback, options?) signature.'
                ),
            void 0 !== l &&
                En(
                    'watch() "once" option is only respected when using the watch(source, callback, options?) signature.'
                ));
        const c = u({}, n);
        c.onWarn = En;
        const d = (t && r) || (!t && 'post' !== s);
        let f;
        if (sl)
            if ('sync' === s) {
                const e = Qi();
                f = e.__watcherHandles || (e.__watcherHandles = []);
            } else if (!d) {
                const e = () => {};
                return ((e.stop = a), (e.resume = a), (e.pause = a), e);
            }
        const h = Ka;
        c.call = (e, t, n) => Ln(e, h, t, n);
        let g = !1;
        ('post' === s
            ? (c.scheduler = e => {
                  Ks(e, h && h.suspense);
              })
            : 'sync' !== s &&
              ((g = !0),
              (c.scheduler = (e, t) => {
                  t ? e() : qn(e);
              })),
            (c.augmentJob = e => {
                (t && (e.flags |= 4), g && ((e.flags |= 2), h && ((e.id = h.uid), (e.i = h))));
            }));
        const v = (function (e, t, n = i) {
            const { immediate: r, deep: o, once: s, scheduler: l, augmentJob: c, call: d } = n,
                u = e => {
                    (n.onWarn || we)(
                        'Invalid watch source: ',
                        e,
                        'A watch source can only be a getter/effect function, a ref, a reactive object, or an array of these types.'
                    );
                },
                f = e => (o ? e : Ut(e) || !1 === o || 0 === o ? xn(e, 1) : xn(e));
            let h,
                g,
                v,
                y,
                w = !1,
                S = !1;
            if (
                (Xt(e)
                    ? ((g = () => e.value), (w = Ut(e)))
                    : zt(e)
                      ? ((g = () => f(e)), (w = !0))
                      : m(e)
                        ? ((S = !0),
                          (w = e.some(e => zt(e) || Ut(e))),
                          (g = () =>
                              e.map(e => (Xt(e) ? e.value : zt(e) ? f(e) : b(e) ? (d ? d(e, 2) : e()) : void u(e)))))
                        : b(e)
                          ? (g = t
                                ? d
                                    ? () => d(e, 2)
                                    : e
                                : () => {
                                      if (v) {
                                          qe();
                                          try {
                                              v();
                                          } finally {
                                              We();
                                          }
                                      }
                                      const t = bn;
                                      bn = h;
                                      try {
                                          return d ? d(e, 3, [y]) : e(y);
                                      } finally {
                                          bn = t;
                                      }
                                  })
                          : ((g = a), u(e)),
                t && o)
            ) {
                const e = g,
                    t = !0 === o ? 1 / 0 : o;
                g = () => xn(e(), t);
            }
            const x = Ce(),
                _ = () => {
                    (h.stop(), x && x.active && p(x.effects, h));
                };
            if (s && t) {
                const e = t;
                t = (...t) => {
                    (e(...t), _());
                };
            }
            let T = S ? new Array(e.length).fill(vn) : vn;
            const C = e => {
                if (1 & h.flags && (h.dirty || e))
                    if (t) {
                        const e = h.run();
                        if (o || w || (S ? e.some((e, t) => F(e, T[t])) : F(e, T))) {
                            v && v();
                            const n = bn;
                            bn = h;
                            try {
                                const n = [e, T === vn ? void 0 : S && T[0] === vn ? [] : T, y];
                                ((T = e), d ? d(t, 3, n) : t(...n));
                            } finally {
                                bn = n;
                            }
                        }
                    } else h.run();
            };
            return (
                c && c(C),
                (h = new Ae(g)),
                (h.scheduler = l ? () => l(C, !1) : C),
                (y = e => Sn(e, !1, h)),
                (v = h.onStop =
                    () => {
                        const e = yn.get(h);
                        if (e) {
                            if (d) d(e, 4);
                            else for (const t of e) t();
                            yn.delete(h);
                        }
                    }),
                (h.onTrack = n.onTrack),
                (h.onTrigger = n.onTrigger),
                t ? (r ? C(!0) : (T = h.run())) : l ? l(C.bind(null, !0), !0) : h.run(),
                (_.pause = h.pause.bind(h)),
                (_.resume = h.resume.bind(h)),
                (_.stop = _),
                _
            );
        })(e, t, c);
        return (sl && (f ? f.push(v) : d && v()), v);
    }
    function os(e, t, n) {
        const r = this.proxy,
            o = w(e) ? (e.includes('.') ? is(r, e) : () => r[e]) : e.bind(r, r);
        let i;
        b(t) ? (i = t) : ((i = t.handler), (n = t));
        const s = Za(this),
            a = rs(o, i.bind(r), n);
        return (s(), a);
    }
    function is(e, t) {
        const n = t.split('.');
        return () => {
            let t = e;
            for (let e = 0; e < n.length && t; e++) t = t[n[e]];
            return t;
        };
    }
    function ss(e, t, n = i) {
        const r = Xa();
        if (!r) return (En('useModel() called without active instance.'), Jt());
        const o = N(t);
        if (!r.propsOptions[0][o]) return (En(`useModel() called with prop "${t}" which is not declared.`), Jt());
        const s = R(t),
            a = as(e, o),
            l = ln((a, l) => {
                let c,
                    d,
                    u = i;
                return (
                    ts(() => {
                        const t = e[o];
                        F(c, t) && ((c = t), l());
                    }),
                    {
                        get: () => (a(), n.get ? n.get(c) : c),
                        set(e) {
                            const a = n.set ? n.set(e) : e;
                            if (!(F(a, c) || (u !== i && F(e, u)))) return;
                            const p = r.vnode.props;
                            ((p &&
                                (t in p || o in p || s in p) &&
                                (`onUpdate:${t}` in p || `onUpdate:${o}` in p || `onUpdate:${s}` in p)) ||
                                ((c = e), l()),
                                r.emit(`update:${t}`, a),
                                F(e, a) && F(e, u) && !F(a, d) && l(),
                                (u = e),
                                (d = a));
                        }
                    }
                );
            });
        return (
            (l[Symbol.iterator] = () => {
                let e = 0;
                return { next: () => (e < 2 ? { value: e++ ? a || i : l, done: !1 } : { done: !0 }) };
            }),
            l
        );
    }
    const as = (e, t) =>
        'modelValue' === t || 'model-value' === t
            ? e.modelModifiers
            : e[`${t}Modifiers`] || e[`${N(t)}Modifiers`] || e[`${R(t)}Modifiers`];
    function ls(e, t, ...n) {
        if (e.isUnmounted) return;
        const r = e.vnode.props || i;
        {
            const {
                emitsOptions: r,
                propsOptions: [o]
            } = e;
            if (r)
                if (t in r) {
                    const e = r[t];
                    b(e) && (e(...n) || En(`Invalid event arguments: event validation failed for event "${t}".`));
                } else
                    (o && B(N(t)) in o) ||
                        En(
                            `Component emitted event "${t}" but it is neither declared in the emits option nor as an "${B(N(t))}" prop.`
                        );
        }
        let o = n;
        const s = t.startsWith('update:'),
            a = s && as(r, t.slice(7));
        (a && (a.trim && (o = n.map(e => (w(e) ? e.trim() : e))), a.number && (o = n.map(V))),
            (function (e, t, n) {
                cr('component:emit', e.appContext.app, e, t, n);
            })(e, t, o));
        {
            const n = t.toLowerCase();
            n !== t &&
                r[B(n)] &&
                En(
                    `Event "${n}" is emitted in component ${yl(e, e.type)} but the handler is registered for "${t}". Note that HTML attributes are case-insensitive and you cannot use v-on to listen to camelCase events when using in-DOM templates. You should probably use "${R(t)}" instead of "${t}".`
                );
        }
        let l,
            c = r[(l = B(t))] || r[(l = B(N(t)))];
        (!c && s && (c = r[(l = B(R(t)))]), c && Ln(c, e, 6, o));
        const d = r[l + 'Once'];
        if (d) {
            if (e.emitted) {
                if (e.emitted[l]) return;
            } else e.emitted = {};
            ((e.emitted[l] = !0), Ln(d, e, 6, o));
        }
    }
    const cs = new WeakMap();
    function ds(e, t, n = !1) {
        const r = n ? cs : t.emitsCache,
            o = r.get(e);
        if (void 0 !== o) return o;
        const i = e.emits;
        let s = {},
            a = !1;
        if (!b(e)) {
            const r = e => {
                const n = ds(e, t, !0);
                n && ((a = !0), u(s, n));
            };
            (!n && t.mixins.length && t.mixins.forEach(r), e.extends && r(e.extends), e.mixins && e.mixins.forEach(r));
        }
        return i || a
            ? (m(i) ? i.forEach(e => (s[e] = null)) : u(s, i), x(e) && r.set(e, s), s)
            : (x(e) && r.set(e, null), null);
    }
    function us(e, t) {
        return (
            !(!e || !c(t)) &&
            ((t = t.slice(2).replace(/Once$/, '')), h(e, t[0].toLowerCase() + t.slice(1)) || h(e, R(t)) || h(e, t))
        );
    }
    let ps = !1;
    function fs() {
        ps = !0;
    }
    function hs(e) {
        const {
                type: t,
                vnode: n,
                proxy: r,
                withProxy: o,
                propsOptions: [i],
                slots: s,
                attrs: a,
                emit: l,
                render: u,
                renderCache: p,
                props: f,
                data: h,
                setupState: m,
                ctx: g,
                inheritAttrs: v
            } = e,
            y = Sr(e);
        let b, w;
        ps = !1;
        try {
            if (4 & n.shapeFlag) {
                const e = o || r,
                    t = m.__isScriptSetup
                        ? new Proxy(e, {
                              get: (e, t, n) => (
                                  En(
                                      `Property '${String(t)}' was accessed via 'this'. Avoid using 'this' in templates.`
                                  ),
                                  Reflect.get(e, t, n)
                              )
                          })
                        : e;
                ((b = Va(u.call(t, e, p, jt(f), m, h, g))), (w = a));
            } else {
                const e = t;
                (a === f && fs(),
                    (b = Va(
                        e.length > 1
                            ? e(jt(f), {
                                  get attrs() {
                                      return (fs(), jt(a));
                                  },
                                  slots: s,
                                  emit: l
                              })
                            : e(jt(f), null)
                    )),
                    (w = t.props ? a : vs(a)));
            }
        } catch (t) {
            ((ya.length = 0), Rn(t, e, 1), (b = La(ga)));
        }
        let S,
            x = b;
        if ((b.patchFlag > 0 && 2048 & b.patchFlag && ([x, S] = ms(b)), w && !1 !== v)) {
            const e = Object.keys(w),
                { shapeFlag: t } = x;
            if (e.length)
                if (7 & t) (i && e.some(d) && (w = ys(w, i)), (x = $a(x, w, !1, !0)));
                else if (!ps && x.type !== ga) {
                    const e = Object.keys(a),
                        t = [],
                        n = [];
                    for (let r = 0, o = e.length; r < o; r++) {
                        const o = e[r];
                        c(o) ? d(o) || t.push(o[2].toLowerCase() + o.slice(3)) : n.push(o);
                    }
                    (n.length &&
                        En(
                            `Extraneous non-props attributes (${n.join(', ')}) were passed to component but could not be automatically inherited because component renders fragment or text or teleport root nodes.`
                        ),
                        t.length &&
                            En(
                                `Extraneous non-emits event listeners (${t.join(', ')}) were passed to component but could not be automatically inherited because component renders fragment or text root nodes. If the listener is intended to be a component custom event listener only, declare it using the "emits" option.`
                            ));
                }
        }
        return (
            n.dirs &&
                (bs(x) ||
                    En(
                        'Runtime directive used on component with non-element root node. The directives will not function as intended.'
                    ),
                (x = $a(x, null, !1, !0)),
                (x.dirs = x.dirs ? x.dirs.concat(n.dirs) : n.dirs)),
            n.transition &&
                (bs(x) || En('Component inside <Transition> renders non-element root node that cannot be animated.'),
                Zr(x, n.transition)),
            S ? S(x) : (b = x),
            Sr(y),
            b
        );
    }
    const ms = e => {
        const t = e.children,
            n = e.dynamicChildren,
            r = gs(t, !1);
        if (!r) return [e, void 0];
        if (r.patchFlag > 0 && 2048 & r.patchFlag) return ms(r);
        const o = t.indexOf(r),
            i = n ? n.indexOf(r) : -1;
        return [
            Va(r),
            r => {
                ((t[o] = r), n && (i > -1 ? (n[i] = r) : r.patchFlag > 0 && (e.dynamicChildren = [...n, r])));
            }
        ];
    };
    function gs(e, t = !0) {
        let n;
        for (let r = 0; r < e.length; r++) {
            const o = e[r];
            if (!Aa(o)) return;
            if (o.type !== ga || 'v-if' === o.children) {
                if (n) return;
                if (((n = o), t && n.patchFlag > 0 && 2048 & n.patchFlag)) return gs(n.children);
            }
        }
        return n;
    }
    const vs = e => {
            let t;
            for (const n in e) ('class' === n || 'style' === n || c(n)) && ((t || (t = {}))[n] = e[n]);
            return t;
        },
        ys = (e, t) => {
            const n = {};
            for (const r in e) (d(r) && r.slice(9) in t) || (n[r] = e[r]);
            return n;
        },
        bs = e => 7 & e.shapeFlag || e.type === ga;
    function ws(e, t, n) {
        const r = Object.keys(t);
        if (r.length !== Object.keys(e).length) return !0;
        for (let o = 0; o < r.length; o++) {
            const i = r[o];
            if (t[i] !== e[i] && !us(n, i)) return !0;
        }
        return !1;
    }
    function Ss({ vnode: e, parent: t }, n) {
        for (; t; ) {
            const r = t.subTree;
            if ((r.suspense && r.suspense.activeBranch === e && (r.el = e.el), r !== e)) break;
            (((e = t.vnode).el = n), (t = t.parent));
        }
    }
    const xs = {},
        _s = () => Object.create(xs),
        Ts = e => Object.getPrototypeOf(e) === xs;
    function Cs(e, t, n, r) {
        const [o, s] = e.propsOptions;
        let a,
            l = !1;
        if (t)
            for (let i in t) {
                if (O(i)) continue;
                const c = t[i];
                let d;
                o && h(o, (d = N(i)))
                    ? s && s.includes(d)
                        ? ((a || (a = {}))[d] = c)
                        : (n[d] = c)
                    : us(e.emitsOptions, i) || (i in r && c === r[i]) || ((r[i] = c), (l = !0));
            }
        if (s) {
            const t = Wt(n),
                r = a || i;
            for (let i = 0; i < s.length; i++) {
                const a = s[i];
                n[a] = ks(o, t, a, r[a], e, !h(r, a));
            }
        }
        return l;
    }
    function ks(e, t, n, r, o, i) {
        const s = e[n];
        if (null != s) {
            const e = h(s, 'default');
            if (e && void 0 === r) {
                const e = s.default;
                if (s.type !== Function && !s.skipFactory && b(e)) {
                    const { propsDefaults: i } = o;
                    if (n in i) r = i[n];
                    else {
                        const s = Za(o);
                        ((r = i[n] = e.call(null, t)), s());
                    }
                } else r = e;
                o.ce && o.ce._setProp(n, r);
            }
            s[0] && (i && !e ? (r = !1) : !s[1] || ('' !== r && r !== R(n)) || (r = !0));
        }
        return r;
    }
    const Es = new WeakMap();
    function As(e, t, n = !1) {
        const r = n ? Es : t.propsCache,
            o = r.get(e);
        if (o) return o;
        const a = e.props,
            l = {},
            c = [];
        let d = !1;
        if (!b(e)) {
            const r = e => {
                d = !0;
                const [n, r] = As(e, t, !0);
                (u(l, n), r && c.push(...r));
            };
            (!n && t.mixins.length && t.mixins.forEach(r), e.extends && r(e.extends), e.mixins && e.mixins.forEach(r));
        }
        if (!a && !d) return (x(e) && r.set(e, s), s);
        if (m(a))
            for (let e = 0; e < a.length; e++) {
                w(a[e]) || En('props must be strings when using array syntax.', a[e]);
                const t = N(a[e]);
                Os(t) && (l[t] = i);
            }
        else if (a) {
            x(a) || En('invalid props options', a);
            for (const e in a) {
                const t = N(e);
                if (Os(t)) {
                    const n = a[e],
                        r = (l[t] = m(n) || b(n) ? { type: n } : u({}, n)),
                        o = r.type;
                    let i = !1,
                        s = !0;
                    if (m(o))
                        for (let e = 0; e < o.length; ++e) {
                            const t = o[e],
                                n = b(t) && t.name;
                            if ('Boolean' === n) {
                                i = !0;
                                break;
                            }
                            'String' === n && (s = !1);
                        }
                    else i = b(o) && 'Boolean' === o.name;
                    ((r[0] = i), (r[1] = s), (i || h(r, 'default')) && c.push(t));
                }
            }
        }
        const p = [l, c];
        return (x(e) && r.set(e, p), p);
    }
    function Os(e) {
        return ('$' !== e[0] && !O(e)) || (En(`Invalid prop name: "${e}" is a reserved property.`), !1);
    }
    function Is(e, t, n) {
        const r = Wt(t),
            o = n.propsOptions[0],
            i = Object.keys(e).map(e => N(e));
        for (const e in o) {
            let t = o[e];
            null != t && Ms(e, r[e], t, jt(r), !i.includes(e));
        }
    }
    function Ms(e, t, n, r, o) {
        const { type: i, required: s, validator: a, skipCheck: l } = n;
        if (s && o) En('Missing required prop: "' + e + '"');
        else if (null != t || s) {
            if (null != i && !0 !== i && !l) {
                let n = !1;
                const r = m(i) ? i : [i],
                    o = [];
                for (let e = 0; e < r.length && !n; e++) {
                    const { valid: i, expectedType: s } = Ns(t, r[e]);
                    (o.push(s || ''), (n = i));
                }
                if (!n)
                    return void En(
                        (function (e, t, n) {
                            if (0 === n.length)
                                return `Prop type [] for prop "${e}" won't match anything. Did you mean to use type Array instead?`;
                            let r = `Invalid prop: type check failed for prop "${e}". Expected ${n.map($).join(' | ')}`;
                            const o = n[0],
                                i = k(t),
                                s = Ls(t, o),
                                a = Ls(t, i);
                            return (
                                1 === n.length &&
                                    Rs(o) &&
                                    !(function (...e) {
                                        return e.some(e => 'boolean' === e.toLowerCase());
                                    })(o, i) &&
                                    (r += ` with value ${s}`),
                                (r += `, got ${i} `),
                                Rs(i) && (r += `with value ${a}.`),
                                r
                            );
                        })(e, t, o)
                    );
            }
            a && !a(t, r) && En('Invalid prop: custom validator check failed for prop "' + e + '".');
        }
    }
    const Ps = o('String,Number,Boolean,Function,Symbol,BigInt');
    function Ns(e, t) {
        let n;
        const r =
            null === (o = t)
                ? 'null'
                : 'function' == typeof o
                  ? o.name || ''
                  : ('object' == typeof o && o.constructor && o.constructor.name) || '';
        var o;
        if ('null' === r) n = null === e;
        else if (Ps(r)) {
            const o = typeof e;
            ((n = o === r.toLowerCase()), n || 'object' !== o || (n = e instanceof t));
        } else n = 'Object' === r ? x(e) : 'Array' === r ? m(e) : e instanceof t;
        return { valid: n, expectedType: r };
    }
    function Ls(e, t) {
        return 'String' === t ? `"${e}"` : 'Number' === t ? `${Number(e)}` : `${e}`;
    }
    function Rs(e) {
        return ['string', 'number', 'boolean'].some(t => e.toLowerCase() === t);
    }
    const $s = e => '_' === e || '_ctx' === e || '$stable' === e,
        Bs = e => (m(e) ? e.map(Va) : [Va(e)]),
        Fs = (e, t, n) => {
            if (t._n) return t;
            const r = Cr(
                (...r) => (
                    !Ka ||
                        (null === n && br) ||
                        (n && n.root !== Ka.root) ||
                        En(
                            `Slot "${e}" invoked outside of the render function: this will not track dependencies used in the slot. Invoke the slot function inside the render function instead.`
                        ),
                    Bs(t(...r))
                ),
                n
            );
            return ((r._c = !1), r);
        },
        Ds = (e, t, n) => {
            const r = e._ctx;
            for (const n in e) {
                if ($s(n)) continue;
                const o = e[n];
                if (b(o)) t[n] = Fs(n, o, r);
                else if (null != o) {
                    En(`Non-function value encountered for slot "${n}". Prefer function slots for better performance.`);
                    const e = Bs(o);
                    t[n] = () => e;
                }
            }
        },
        js = (e, t) => {
            Mo(e.vnode) ||
                En('Non-function value encountered for default slot. Prefer function slots for better performance.');
            const n = Bs(t);
            e.slots.default = () => n;
        },
        Vs = (e, t, n) => {
            for (const r in t) (!n && $s(r)) || (e[r] = t[r]);
        },
        zs = (e, t, n) => {
            const r = (e.slots = _s());
            if (32 & e.vnode.shapeFlag) {
                const e = t._;
                e ? (Vs(r, t, n), n && j(r, '_', e, !0)) : Ds(t, r);
            } else t && js(e, t);
        },
        Hs = (e, t, n) => {
            const { vnode: r, slots: o } = e;
            let s = !0,
                a = i;
            if (32 & r.shapeFlag) {
                const r = t._;
                (r
                    ? Zn
                        ? (Vs(o, t, n), rt(e, 'set', '$slots'))
                        : n && 1 === r
                          ? (s = !1)
                          : Vs(o, t, n)
                    : ((s = !t.$stable), Ds(t, o)),
                    (a = t));
            } else t && (js(e, t), (a = { default: 1 }));
            if (s) for (const e in o) $s(e) || null != a[e] || delete o[e];
        };
    let Us, qs;
    function Ws(e, t) {
        (e.appContext.config.performance && Ys() && qs.mark(`vue-${t}-${e.uid}`),
            gr(e, t, Ys() ? qs.now() : Date.now()));
    }
    function Gs(e, t) {
        if (e.appContext.config.performance && Ys()) {
            const n = `vue-${t}-${e.uid}`,
                r = n + ':end',
                o = `<${yl(e, e.type)}> ${t}`;
            (qs.mark(r), qs.measure(o, n, r), qs.clearMeasures(o), qs.clearMarks(n), qs.clearMarks(r));
        }
        vr(e, t, Ys() ? qs.now() : Date.now());
    }
    function Ys() {
        return (
            void 0 !== Us ||
                ('undefined' != typeof window && window.performance
                    ? ((Us = !0), (qs = window.performance))
                    : (Us = !1)),
            Us
        );
    }
    const Ks = pa;
    function Xs(e) {
        return Qs(e);
    }
    function Js(e) {
        return Qs(e, ho);
    }
    function Qs(e, t) {
        !(function () {
            const e = [];
            if (
                ('boolean' != typeof __VUE_PROD_HYDRATION_MISMATCH_DETAILS__ &&
                    (e.push('__VUE_PROD_HYDRATION_MISMATCH_DETAILS__'),
                    (U().__VUE_PROD_HYDRATION_MISMATCH_DETAILS__ = !1)),
                e.length)
            ) {
                const t = e.length > 1;
                console.warn(
                    `Feature flag${t ? 's' : ''} ${e.join(', ')} ${t ? 'are' : 'is'} not explicitly defined. You are running the esm-bundler build of Vue, which expects these compile-time feature flags to be globally injected via the bundler config in order to get better tree-shaking in the production bundle.\n\nFor more details, see https://link.vuejs.org/feature-flags.`
                );
            }
        })();
        const n = U();
        ((n.__VUE__ = !0), dr(n.__VUE_DEVTOOLS_GLOBAL_HOOK__, n));
        const {
                insert: r,
                remove: o,
                patchProp: l,
                createElement: c,
                createText: d,
                createComment: u,
                setText: p,
                setElementText: f,
                parentNode: m,
                nextSibling: g,
                setScopeId: v = a,
                insertStaticContent: y
            } = e,
            b = (e, t, n, r = null, o = null, i = null, s = void 0, a = null, l = !Zn && !!t.dynamicChildren) => {
                if (e === t) return;
                (e && !Oa(e, t) && ((r = Z(e)), Y(e, o, i, !0), (e = null)),
                    -2 === t.patchFlag && ((l = !1), (t.dynamicChildren = null)));
                const { type: c, ref: d, shapeFlag: u } = t;
                switch (c) {
                    case ma:
                        w(e, t, n, r);
                        break;
                    case ga:
                        S(e, t, n, r);
                        break;
                    case va:
                        null == e ? x(t, n, r, s) : _(e, t, n, s);
                        break;
                    case ha:
                        L(e, t, n, r, o, i, s, a, l);
                        break;
                    default:
                        1 & u
                            ? C(e, t, n, r, o, i, s, a, l)
                            : 6 & u
                              ? $(e, t, n, r, o, i, s, a, l)
                              : 64 & u || 128 & u
                                ? c.process(e, t, n, r, o, i, s, a, l, ne)
                                : En('Invalid VNode type:', c, `(${typeof c})`);
                }
                null != d && o
                    ? ao(d, e && e.ref, i, t || e, !t)
                    : null == d && e && null != e.ref && ao(e.ref, null, i, e, !0);
            },
            w = (e, t, n, o) => {
                if (null == e) r((t.el = d(t.children)), n, o);
                else {
                    const n = (t.el = e.el);
                    t.children !== e.children && p(n, t.children);
                }
            },
            S = (e, t, n, o) => {
                null == e ? r((t.el = u(t.children || '')), n, o) : (t.el = e.el);
            },
            x = (e, t, n, r) => {
                [e.el, e.anchor] = y(e.children, t, n, r, e.el, e.anchor);
            },
            _ = (e, t, n, r) => {
                if (t.children !== e.children) {
                    const o = g(e.anchor);
                    (T(e), ([t.el, t.anchor] = y(t.children, n, o, r)));
                } else ((t.el = e.el), (t.anchor = e.anchor));
            },
            T = ({ el: e, anchor: t }) => {
                let n;
                for (; e && e !== t; ) ((n = g(e)), o(e), (e = n));
                o(t);
            },
            C = (e, t, n, r, o, i, s, a, l) => {
                if (('svg' === t.type ? (s = 'svg') : 'math' === t.type && (s = 'mathml'), null == e))
                    k(t, n, r, o, i, s, a, l);
                else {
                    const n = e.el && e.el._isVueCE ? e.el : null;
                    try {
                        (n && n._beginPatch(), I(e, t, o, i, s, a, l));
                    } finally {
                        n && n._endPatch();
                    }
                }
            },
            k = (e, t, n, o, i, s, a, d) => {
                let u, p;
                const { props: h, shapeFlag: m, transition: g, dirs: v } = e;
                if (
                    ((u = e.el = c(e.type, s, h && h.is, h)),
                    8 & m ? f(u, e.children) : 16 & m && A(e.children, u, null, o, i, Zs(e, s), a, d),
                    v && Ar(e, null, o, 'created'),
                    E(u, e, e.scopeId, a, o),
                    h)
                ) {
                    for (const e in h) 'value' === e || O(e) || l(u, e, null, h[e], s, o);
                    ('value' in h && l(u, 'value', null, h.value, s), (p = h.onVnodeBeforeMount) && qa(p, o, e));
                }
                (j(u, '__vnode', e, !0), j(u, '__vueParentComponent', o, !0), v && Ar(e, null, o, 'beforeMount'));
                const y = ta(i, g);
                (y && g.beforeEnter(u),
                    r(u, t, n),
                    ((p = h && h.onVnodeMounted) || y || v) &&
                        Ks(() => {
                            (p && qa(p, o, e), y && g.enter(u), v && Ar(e, null, o, 'mounted'));
                        }, i));
            },
            E = (e, t, n, r, o) => {
                if ((n && v(e, n), r)) for (let t = 0; t < r.length; t++) v(e, r[t]);
                if (o) {
                    let n = o.subTree;
                    if (
                        (n.patchFlag > 0 && 2048 & n.patchFlag && (n = gs(n.children) || n),
                        t === n || (ia(n.type) && (n.ssContent === t || n.ssFallback === t)))
                    ) {
                        const t = o.vnode;
                        E(e, t, t.scopeId, t.slotScopeIds, o.parent);
                    }
                }
            },
            A = (e, t, n, r, o, i, s, a, l = 0) => {
                for (let c = l; c < e.length; c++) {
                    const l = (e[c] = a ? za(e[c]) : Va(e[c]));
                    b(null, l, t, n, r, o, i, s, a);
                }
            },
            I = (e, t, n, r, o, s, a) => {
                const c = (t.el = e.el);
                c.__vnode = t;
                let { patchFlag: d, dynamicChildren: u, dirs: p } = t;
                d |= 16 & e.patchFlag;
                const h = e.props || i,
                    m = t.props || i;
                let g;
                if (
                    (n && ea(n, !1),
                    (g = m.onVnodeBeforeUpdate) && qa(g, n, t, e),
                    p && Ar(t, e, n, 'beforeUpdate'),
                    n && ea(n, !0),
                    Zn && ((d = 0), (a = !1), (u = null)),
                    ((h.innerHTML && null == m.innerHTML) || (h.textContent && null == m.textContent)) && f(c, ''),
                    u
                        ? (M(e.dynamicChildren, u, c, n, r, Zs(t, o), s), na(e, t))
                        : a || H(e, t, c, null, n, r, Zs(t, o), s, !1),
                    d > 0)
                ) {
                    if (16 & d) P(c, h, m, n, o);
                    else if (
                        (2 & d && h.class !== m.class && l(c, 'class', null, m.class, o),
                        4 & d && l(c, 'style', h.style, m.style, o),
                        8 & d)
                    ) {
                        const e = t.dynamicProps;
                        for (let t = 0; t < e.length; t++) {
                            const r = e[t],
                                i = h[r],
                                s = m[r];
                            (s === i && 'value' !== r) || l(c, r, i, s, o, n);
                        }
                    }
                    1 & d && e.children !== t.children && f(c, t.children);
                } else a || null != u || P(c, h, m, n, o);
                ((g = m.onVnodeUpdated) || p) &&
                    Ks(() => {
                        (g && qa(g, n, t, e), p && Ar(t, e, n, 'updated'));
                    }, r);
            },
            M = (e, t, n, r, o, i, s) => {
                for (let a = 0; a < t.length; a++) {
                    const l = e[a],
                        c = t[a],
                        d = l.el && (l.type === ha || !Oa(l, c) || 198 & l.shapeFlag) ? m(l.el) : n;
                    b(l, c, d, null, r, o, i, s, !0);
                }
            },
            P = (e, t, n, r, o) => {
                if (t !== n) {
                    if (t !== i) for (const i in t) O(i) || i in n || l(e, i, t[i], null, o, r);
                    for (const i in n) {
                        if (O(i)) continue;
                        const s = n[i],
                            a = t[i];
                        s !== a && 'value' !== i && l(e, i, a, s, o, r);
                    }
                    'value' in n && l(e, 'value', t.value, n.value, o);
                }
            },
            L = (e, t, n, o, i, s, a, l, c) => {
                const u = (t.el = e ? e.el : d('')),
                    p = (t.anchor = e ? e.anchor : d(''));
                let { patchFlag: f, dynamicChildren: h, slotScopeIds: m } = t;
                ((Zn || 2048 & f) && ((f = 0), (c = !1), (h = null)),
                    m && (l = l ? l.concat(m) : m),
                    null == e
                        ? (r(u, n, o), r(p, n, o), A(t.children || [], n, p, i, s, a, l, c))
                        : f > 0 && 64 & f && h && e.dynamicChildren
                          ? (M(e.dynamicChildren, h, n, i, s, a, l), na(e, t))
                          : H(e, t, n, p, i, s, a, l, c));
            },
            $ = (e, t, n, r, o, i, s, a, l) => {
                ((t.slotScopeIds = a),
                    null == e
                        ? 512 & t.shapeFlag
                            ? o.ctx.activate(t, n, r, s, l)
                            : B(t, n, r, o, i, s, l)
                        : F(e, t, l));
            },
            B = (e, t, n, r, o, i, s) => {
                const a = (e.component = Ya(e, r, o));
                if (
                    (a.type.__hmrId &&
                        (function (e) {
                            const t = e.type.__hmrId;
                            let n = tr.get(t);
                            (n || (nr(t, e.type), (n = tr.get(t))), n.instances.add(e));
                        })(a),
                    Tn(e),
                    Ws(a, 'mount'),
                    Mo(e) && (a.ctx.renderer = ne),
                    Ws(a, 'init'),
                    al(a, !1, s),
                    Gs(a, 'init'),
                    Zn && (e.el = null),
                    a.asyncDep)
                ) {
                    if ((o && o.registerDep(a, V, s), !e.el)) {
                        const r = (a.subTree = La(ga));
                        (S(null, r, t, n), (e.placeholder = r.el));
                    }
                } else V(a, e, t, n, o, i, s);
                (Cn(), Gs(a, 'mount'));
            },
            F = (e, t, n) => {
                const r = (t.component = e.component);
                if (
                    (function (e, t, n) {
                        const { props: r, children: o, component: i } = e,
                            { props: s, children: a, patchFlag: l } = t,
                            c = i.emitsOptions;
                        if ((o || a) && Zn) return !0;
                        if (t.dirs || t.transition) return !0;
                        if (!(n && l >= 0))
                            return !((!o && !a) || (a && a.$stable)) || (r !== s && (r ? !s || ws(r, s, c) : !!s));
                        if (1024 & l) return !0;
                        if (16 & l) return r ? ws(r, s, c) : !!s;
                        if (8 & l) {
                            const e = t.dynamicProps;
                            for (let t = 0; t < e.length; t++) {
                                const n = e[t];
                                if (s[n] !== r[n] && !us(c, n)) return !0;
                            }
                        }
                        return !1;
                    })(e, t, n)
                ) {
                    if (r.asyncDep && !r.asyncResolved) return (Tn(t), z(r, t, n), void Cn());
                    ((r.next = t), r.update());
                } else ((t.el = e.el), (r.vnode = t));
            },
            V = (e, t, n, r, o, i, s) => {
                const a = () => {
                    if (e.isMounted) {
                        let { next: t, bu: n, u: r, parent: l, vnode: c } = e;
                        {
                            const n = ra(e);
                            if (n)
                                return (
                                    t && ((t.el = c.el), z(e, t, s)),
                                    void n.asyncDep.then(() => {
                                        e.isUnmounted || a();
                                    })
                                );
                        }
                        let d,
                            u = t;
                        (Tn(t || e.vnode),
                            ea(e, !1),
                            t ? ((t.el = c.el), z(e, t, s)) : (t = c),
                            n && D(n),
                            (d = t.props && t.props.onVnodeBeforeUpdate) && qa(d, l, t, c),
                            ea(e, !0),
                            Ws(e, 'render'));
                        const p = hs(e);
                        Gs(e, 'render');
                        const f = e.subTree;
                        ((e.subTree = p),
                            Ws(e, 'patch'),
                            b(f, p, m(f.el), Z(f), e, o, i),
                            Gs(e, 'patch'),
                            (t.el = p.el),
                            null === u && Ss(e, p.el),
                            r && Ks(r, o),
                            (d = t.props && t.props.onVnodeUpdated) && Ks(() => qa(d, l, t, c), o),
                            pr(e),
                            Cn());
                    } else {
                        let s;
                        const { el: a, props: l } = t,
                            { bm: c, m: d, parent: u, root: p, type: f } = e,
                            h = Ao(t);
                        if (
                            (ea(e, !1),
                            c && D(c),
                            !h && (s = l && l.onVnodeBeforeMount) && qa(s, u, t),
                            ea(e, !0),
                            a && oe)
                        ) {
                            const t = () => {
                                (Ws(e, 'render'),
                                    (e.subTree = hs(e)),
                                    Gs(e, 'render'),
                                    Ws(e, 'hydrate'),
                                    oe(a, e.subTree, e, o, null),
                                    Gs(e, 'hydrate'));
                            };
                            h && f.__asyncHydrate ? f.__asyncHydrate(a, e, t) : t();
                        } else {
                            (p.ce && !1 !== p.ce._def.shadowRoot && p.ce._injectChildStyle(f), Ws(e, 'render'));
                            const s = (e.subTree = hs(e));
                            (Gs(e, 'render'), Ws(e, 'patch'), b(null, s, n, r, e, o, i), Gs(e, 'patch'), (t.el = s.el));
                        }
                        if ((d && Ks(d, o), !h && (s = l && l.onVnodeMounted))) {
                            const e = t;
                            Ks(() => qa(s, u, e), o);
                        }
                        ((256 & t.shapeFlag || (u && Ao(u.vnode) && 256 & u.vnode.shapeFlag)) && e.a && Ks(e.a, o),
                            (e.isMounted = !0),
                            ur(e),
                            (t = n = r = null));
                    }
                };
                e.scope.on();
                const l = (e.effect = new Ae(a));
                e.scope.off();
                const c = (e.update = l.run.bind(l)),
                    d = (e.job = l.runIfDirty.bind(l));
                ((d.i = e),
                    (d.id = e.uid),
                    (l.scheduler = () => qn(d)),
                    ea(e, !0),
                    (l.onTrack = e.rtc ? t => D(e.rtc, t) : void 0),
                    (l.onTrigger = e.rtg ? t => D(e.rtg, t) : void 0),
                    c());
            },
            z = (e, t, n) => {
                t.component = e;
                const r = e.vnode.props;
                ((e.vnode = t),
                    (e.next = null),
                    (function (e, t, n, r) {
                        const {
                                props: o,
                                attrs: i,
                                vnode: { patchFlag: s }
                            } = e,
                            a = Wt(o),
                            [l] = e.propsOptions;
                        let c = !1;
                        if (
                            (function (e) {
                                for (; e; ) {
                                    if (e.type.__hmrId) return !0;
                                    e = e.parent;
                                }
                            })(e) ||
                            !(r || s > 0) ||
                            16 & s
                        ) {
                            let r;
                            Cs(e, t, o, i) && (c = !0);
                            for (const i in a)
                                (t && (h(t, i) || ((r = R(i)) !== i && h(t, r)))) ||
                                    (l
                                        ? !n ||
                                          (void 0 === n[i] && void 0 === n[r]) ||
                                          (o[i] = ks(l, a, i, void 0, e, !0))
                                        : delete o[i]);
                            if (i !== a) for (const e in i) (t && h(t, e)) || (delete i[e], (c = !0));
                        } else if (8 & s) {
                            const n = e.vnode.dynamicProps;
                            for (let r = 0; r < n.length; r++) {
                                let s = n[r];
                                if (us(e.emitsOptions, s)) continue;
                                const d = t[s];
                                if (l)
                                    if (h(i, s)) d !== i[s] && ((i[s] = d), (c = !0));
                                    else {
                                        const t = N(s);
                                        o[t] = ks(l, a, t, d, e, !1);
                                    }
                                else d !== i[s] && ((i[s] = d), (c = !0));
                            }
                        }
                        (c && rt(e.attrs, 'set', ''), Is(t || {}, o, e));
                    })(e, t.props, r, n),
                    Hs(e, t.children, n),
                    qe(),
                    Yn(e),
                    We());
            },
            H = (e, t, n, r, o, i, s, a, l = !1) => {
                const c = e && e.children,
                    d = e ? e.shapeFlag : 0,
                    u = t.children,
                    { patchFlag: p, shapeFlag: h } = t;
                if (p > 0) {
                    if (128 & p) return void W(c, u, n, r, o, i, s, a, l);
                    if (256 & p) return void q(c, u, n, r, o, i, s, a, l);
                }
                8 & h
                    ? (16 & d && Q(c, o, i), u !== c && f(n, u))
                    : 16 & d
                      ? 16 & h
                          ? W(c, u, n, r, o, i, s, a, l)
                          : Q(c, o, i, !0)
                      : (8 & d && f(n, ''), 16 & h && A(u, n, r, o, i, s, a, l));
            },
            q = (e, t, n, r, o, i, a, l, c) => {
                t = t || s;
                const d = (e = e || s).length,
                    u = t.length,
                    p = Math.min(d, u);
                let f;
                for (f = 0; f < p; f++) {
                    const r = (t[f] = c ? za(t[f]) : Va(t[f]));
                    b(e[f], r, n, null, o, i, a, l, c);
                }
                d > u ? Q(e, o, i, !0, !1, p) : A(t, n, r, o, i, a, l, c, p);
            },
            W = (e, t, n, r, o, i, a, l, c) => {
                let d = 0;
                const u = t.length;
                let p = e.length - 1,
                    f = u - 1;
                for (; d <= p && d <= f; ) {
                    const r = e[d],
                        s = (t[d] = c ? za(t[d]) : Va(t[d]));
                    if (!Oa(r, s)) break;
                    (b(r, s, n, null, o, i, a, l, c), d++);
                }
                for (; d <= p && d <= f; ) {
                    const r = e[p],
                        s = (t[f] = c ? za(t[f]) : Va(t[f]));
                    if (!Oa(r, s)) break;
                    (b(r, s, n, null, o, i, a, l, c), p--, f--);
                }
                if (d > p) {
                    if (d <= f) {
                        const e = f + 1,
                            s = e < u ? t[e].el : r;
                        for (; d <= f; ) (b(null, (t[d] = c ? za(t[d]) : Va(t[d])), n, s, o, i, a, l, c), d++);
                    }
                } else if (d > f) for (; d <= p; ) (Y(e[d], o, i, !0), d++);
                else {
                    const h = d,
                        m = d,
                        g = new Map();
                    for (d = m; d <= f; d++) {
                        const e = (t[d] = c ? za(t[d]) : Va(t[d]));
                        null != e.key &&
                            (g.has(e.key) &&
                                En(
                                    'Duplicate keys found during update:',
                                    JSON.stringify(e.key),
                                    'Make sure keys are unique.'
                                ),
                            g.set(e.key, d));
                    }
                    let v,
                        y = 0;
                    const w = f - m + 1;
                    let S = !1,
                        x = 0;
                    const _ = new Array(w);
                    for (d = 0; d < w; d++) _[d] = 0;
                    for (d = h; d <= p; d++) {
                        const r = e[d];
                        if (y >= w) {
                            Y(r, o, i, !0);
                            continue;
                        }
                        let s;
                        if (null != r.key) s = g.get(r.key);
                        else
                            for (v = m; v <= f; v++)
                                if (0 === _[v - m] && Oa(r, t[v])) {
                                    s = v;
                                    break;
                                }
                        void 0 === s
                            ? Y(r, o, i, !0)
                            : ((_[s - m] = d + 1),
                              s >= x ? (x = s) : (S = !0),
                              b(r, t[s], n, null, o, i, a, l, c),
                              y++);
                    }
                    const T = S
                        ? (function (e) {
                              const t = e.slice(),
                                  n = [0];
                              let r, o, i, s, a;
                              const l = e.length;
                              for (r = 0; r < l; r++) {
                                  const l = e[r];
                                  if (0 !== l) {
                                      if (((o = n[n.length - 1]), e[o] < l)) {
                                          ((t[r] = o), n.push(r));
                                          continue;
                                      }
                                      for (i = 0, s = n.length - 1; i < s; )
                                          ((a = (i + s) >> 1), e[n[a]] < l ? (i = a + 1) : (s = a));
                                      l < e[n[i]] && (i > 0 && (t[r] = n[i - 1]), (n[i] = r));
                                  }
                              }
                              for (i = n.length, s = n[i - 1]; i-- > 0; ) ((n[i] = s), (s = t[s]));
                              return n;
                          })(_)
                        : s;
                    for (v = T.length - 1, d = w - 1; d >= 0; d--) {
                        const e = m + d,
                            s = t[e],
                            p = t[e + 1],
                            f = e + 1 < u ? p.el || p.placeholder : r;
                        0 === _[d] ? b(null, s, n, f, o, i, a, l, c) : S && (v < 0 || d !== T[v] ? G(s, n, f, 2) : v--);
                    }
                }
            },
            G = (e, t, n, i, s = null) => {
                const { el: a, type: l, transition: c, children: d, shapeFlag: u } = e;
                if (6 & u) G(e.component.subTree, t, n, i);
                else if (128 & u) e.suspense.move(t, n, i);
                else if (64 & u) l.move(e, t, n, ne);
                else if (l !== ha)
                    if (l !== va)
                        if (2 !== i && 1 & u && c)
                            if (0 === i) (c.beforeEnter(a), r(a, t, n), Ks(() => c.enter(a), s));
                            else {
                                const { leave: i, delayLeave: s, afterLeave: l } = c,
                                    d = () => {
                                        e.ctx.isUnmounted ? o(a) : r(a, t, n);
                                    },
                                    u = () => {
                                        (a._isLeaving && a[Vr](!0),
                                            i(a, () => {
                                                (d(), l && l());
                                            }));
                                    };
                                s ? s(a, d, u) : u();
                            }
                        else r(a, t, n);
                    else
                        (({ el: e, anchor: t }, n, o) => {
                            let i;
                            for (; e && e !== t; ) ((i = g(e)), r(e, n, o), (e = i));
                            r(t, n, o);
                        })(e, t, n);
                else {
                    r(a, t, n);
                    for (let e = 0; e < d.length; e++) G(d[e], t, n, i);
                    r(e.anchor, t, n);
                }
            },
            Y = (e, t, n, r = !1, o = !1) => {
                const {
                    type: i,
                    props: s,
                    ref: a,
                    children: l,
                    dynamicChildren: c,
                    shapeFlag: d,
                    patchFlag: u,
                    dirs: p,
                    cacheIndex: f
                } = e;
                if (
                    (-2 === u && (o = !1),
                    null != a && (qe(), ao(a, null, n, e, !0), We()),
                    null != f && (t.renderCache[f] = void 0),
                    256 & d)
                )
                    return void t.ctx.deactivate(e);
                const h = 1 & d && p,
                    m = !Ao(e);
                let g;
                if ((m && (g = s && s.onVnodeBeforeUnmount) && qa(g, t, e), 6 & d)) J(e.component, n, r);
                else {
                    if (128 & d) return void e.suspense.unmount(n, r);
                    (h && Ar(e, null, t, 'beforeUnmount'),
                        64 & d
                            ? e.type.remove(e, t, n, ne, r)
                            : c && !c.hasOnce && (i !== ha || (u > 0 && 64 & u))
                              ? Q(c, t, n, !1, !0)
                              : ((i === ha && 384 & u) || (!o && 16 & d)) && Q(l, t, n),
                        r && K(e));
                }
                ((m && (g = s && s.onVnodeUnmounted)) || h) &&
                    Ks(() => {
                        (g && qa(g, t, e), h && Ar(e, null, t, 'unmounted'));
                    }, n);
            },
            K = e => {
                const { type: t, el: n, anchor: r, transition: i } = e;
                if (t === ha)
                    return void (e.patchFlag > 0 && 2048 & e.patchFlag && i && !i.persisted
                        ? e.children.forEach(e => {
                              e.type === ga ? o(e.el) : K(e);
                          })
                        : X(n, r));
                if (t === va) return void T(e);
                const s = () => {
                    (o(n), i && !i.persisted && i.afterLeave && i.afterLeave());
                };
                if (1 & e.shapeFlag && i && !i.persisted) {
                    const { leave: t, delayLeave: r } = i,
                        o = () => t(n, s);
                    r ? r(e.el, s, o) : o();
                } else s();
            },
            X = (e, t) => {
                let n;
                for (; e !== t; ) ((n = g(e)), o(e), (e = n));
                o(t);
            },
            J = (e, t, n) => {
                e.type.__hmrId &&
                    (function (e) {
                        tr.get(e.type.__hmrId).instances.delete(e);
                    })(e);
                const { bum: r, scope: o, job: i, subTree: s, um: a, m: l, a: c } = e;
                (oa(l),
                    oa(c),
                    r && D(r),
                    o.stop(),
                    i && ((i.flags |= 8), Y(s, e, t, n)),
                    a && Ks(a, t),
                    Ks(() => {
                        e.isUnmounted = !0;
                    }, t),
                    hr(e));
            },
            Q = (e, t, n, r = !1, o = !1, i = 0) => {
                for (let s = i; s < e.length; s++) Y(e[s], t, n, r, o);
            },
            Z = e => {
                if (6 & e.shapeFlag) return Z(e.component.subTree);
                if (128 & e.shapeFlag) return e.suspense.next();
                const t = g(e.anchor || e.el),
                    n = t && t[Or];
                return n ? g(n) : t;
            };
        let ee = !1;
        const te = (e, t, n) => {
                (null == e ? t._vnode && Y(t._vnode, null, null, !0) : b(t._vnode || null, e, t, null, null, null, n),
                    (t._vnode = e),
                    ee || ((ee = !0), Yn(), Kn(), (ee = !1)));
            },
            ne = { p: b, um: Y, m: G, r: K, mt: B, mc: A, pc: H, pbc: M, n: Z, o: e };
        let re, oe;
        return (t && ([re, oe] = t(ne)), { render: te, hydrate: re, createApp: Wi(te, re) });
    }
    function Zs({ type: e, props: t }, n) {
        return ('svg' === n && 'foreignObject' === e) ||
            ('mathml' === n && 'annotation-xml' === e && t && t.encoding && t.encoding.includes('html'))
            ? void 0
            : n;
    }
    function ea({ effect: e, job: t }, n) {
        n ? ((e.flags |= 32), (t.flags |= 4)) : ((e.flags &= -33), (t.flags &= -5));
    }
    function ta(e, t) {
        return (!e || (e && !e.pendingBranch)) && t && !t.persisted;
    }
    function na(e, t, n = !1) {
        const r = e.children,
            o = t.children;
        if (m(r) && m(o))
            for (let e = 0; e < r.length; e++) {
                const t = r[e];
                let i = o[e];
                (1 & i.shapeFlag &&
                    !i.dynamicChildren &&
                    ((i.patchFlag <= 0 || 32 === i.patchFlag) && ((i = o[e] = za(o[e])), (i.el = t.el)),
                    n || -2 === i.patchFlag || na(t, i)),
                    i.type === ma && -1 !== i.patchFlag && (i.el = t.el),
                    i.type !== ga || i.el || (i.el = t.el),
                    i.el && (i.el.__vnode = i));
            }
    }
    function ra(e) {
        const t = e.subTree.component;
        if (t) return t.asyncDep && !t.asyncResolved ? t : ra(t);
    }
    function oa(e) {
        if (e) for (let t = 0; t < e.length; t++) e[t].flags |= 8;
    }
    const ia = e => e.__isSuspense;
    let sa = 0;
    const aa = {
        name: 'Suspense',
        __isSuspense: !0,
        process(e, t, n, r, o, i, s, a, l, c) {
            if (null == e)
                !(function (e, t, n, r, o, i, s, a, l) {
                    const {
                            p: c,
                            o: { createElement: d }
                        } = l,
                        u = d('div'),
                        p = (e.suspense = da(e, o, r, t, u, n, i, s, a, l));
                    (c(null, (p.pendingBranch = e.ssContent), u, null, r, p, i, s),
                        p.deps > 0
                            ? (la(e, 'onPending'),
                              la(e, 'onFallback'),
                              c(null, e.ssFallback, t, n, r, null, i, s),
                              fa(p, e.ssFallback))
                            : p.resolve(!1, !0));
                })(t, n, r, o, i, s, a, l, c);
            else {
                if (i && i.deps > 0 && !e.suspense.isInFallback)
                    return ((t.suspense = e.suspense), (t.suspense.vnode = t), void (t.el = e.el));
                !(function (e, t, n, r, o, i, s, a, { p: l, um: c, o: { createElement: d } }) {
                    const u = (t.suspense = e.suspense);
                    ((u.vnode = t), (t.el = e.el));
                    const p = t.ssContent,
                        f = t.ssFallback,
                        { activeBranch: h, pendingBranch: m, isInFallback: g, isHydrating: v } = u;
                    if (m)
                        ((u.pendingBranch = p),
                            Oa(m, p)
                                ? (l(m, p, u.hiddenContainer, null, o, u, i, s, a),
                                  u.deps <= 0 ? u.resolve() : g && (v || (l(h, f, n, r, o, null, i, s, a), fa(u, f))))
                                : ((u.pendingId = sa++),
                                  v ? ((u.isHydrating = !1), (u.activeBranch = m)) : c(m, o, u),
                                  (u.deps = 0),
                                  (u.effects.length = 0),
                                  (u.hiddenContainer = d('div')),
                                  g
                                      ? (l(null, p, u.hiddenContainer, null, o, u, i, s, a),
                                        u.deps <= 0 ? u.resolve() : (l(h, f, n, r, o, null, i, s, a), fa(u, f)))
                                      : h && Oa(h, p)
                                        ? (l(h, p, n, r, o, u, i, s, a), u.resolve(!0))
                                        : (l(null, p, u.hiddenContainer, null, o, u, i, s, a),
                                          u.deps <= 0 && u.resolve())));
                    else if (h && Oa(h, p)) (l(h, p, n, r, o, u, i, s, a), fa(u, p));
                    else if (
                        (la(t, 'onPending'),
                        (u.pendingBranch = p),
                        512 & p.shapeFlag ? (u.pendingId = p.component.suspenseId) : (u.pendingId = sa++),
                        l(null, p, u.hiddenContainer, null, o, u, i, s, a),
                        u.deps <= 0)
                    )
                        u.resolve();
                    else {
                        const { timeout: e, pendingId: t } = u;
                        e > 0
                            ? setTimeout(() => {
                                  u.pendingId === t && u.fallback(f);
                              }, e)
                            : 0 === e && u.fallback(f);
                    }
                })(e, t, n, r, o, s, a, l, c);
            }
        },
        hydrate: function (e, t, n, r, o, i, s, a, l) {
            const c = (t.suspense = da(t, r, n, e.parentNode, document.createElement('div'), null, o, i, s, a, !0)),
                d = l(e, (c.pendingBranch = t.ssContent), n, c, i, s);
            return (0 === c.deps && c.resolve(!1, !0), d);
        },
        normalize: function (e) {
            const { shapeFlag: t, children: n } = e,
                r = 32 & t;
            ((e.ssContent = ua(r ? n.default : n)), (e.ssFallback = r ? ua(n.fallback) : La(ga)));
        }
    };
    function la(e, t) {
        const n = e.props && e.props[t];
        b(n) && n();
    }
    let ca = !1;
    function da(e, t, n, r, o, i, s, a, l, c, d = !1) {
        ca ||
            ((ca = !0),
            console[console.info ? 'info' : 'log'](
                '<Suspense> is an experimental feature and its API will likely change.'
            ));
        const {
            p: u,
            m: p,
            um: f,
            n: h,
            o: { parentNode: m, remove: g }
        } = c;
        let v;
        const y = (function (e) {
            const t = e.props && e.props.suspensible;
            return null != t && !1 !== t;
        })(e);
        y && t && t.pendingBranch && ((v = t.pendingId), t.deps++);
        const b = e.props ? z(e.props.timeout) : void 0;
        In(b, 'Suspense timeout');
        const w = i,
            S = {
                vnode: e,
                parent: t,
                parentComponent: n,
                namespace: s,
                container: r,
                hiddenContainer: o,
                deps: 0,
                pendingId: sa++,
                timeout: 'number' == typeof b ? b : -1,
                activeBranch: null,
                pendingBranch: null,
                isInFallback: !d,
                isHydrating: d,
                isUnmounted: !1,
                effects: [],
                resolve(e = !1, n = !1) {
                    if (!e && !S.pendingBranch)
                        throw new Error('suspense.resolve() is called without a pending branch.');
                    if (S.isUnmounted)
                        throw new Error('suspense.resolve() is called on an already unmounted suspense boundary.');
                    const {
                        vnode: r,
                        activeBranch: o,
                        pendingBranch: s,
                        pendingId: a,
                        effects: l,
                        parentComponent: c,
                        container: d,
                        isInFallback: u
                    } = S;
                    let g = !1;
                    (S.isHydrating
                        ? (S.isHydrating = !1)
                        : e ||
                          ((g = o && s.transition && 'out-in' === s.transition.mode),
                          g &&
                              (o.transition.afterLeave = () => {
                                  a === S.pendingId &&
                                      (p(s, d, i === w ? h(o) : i, 0),
                                      Gn(l),
                                      u && r.ssFallback && (r.ssFallback.el = null));
                              }),
                          o &&
                              (m(o.el) === d && (i = h(o)),
                              f(o, c, S, !0),
                              !g && u && r.ssFallback && Ks(() => (r.ssFallback.el = null), S)),
                          g || p(s, d, i, 0)),
                        fa(S, s),
                        (S.pendingBranch = null),
                        (S.isInFallback = !1));
                    let b = S.parent,
                        x = !1;
                    for (; b; ) {
                        if (b.pendingBranch) {
                            (b.effects.push(...l), (x = !0));
                            break;
                        }
                        b = b.parent;
                    }
                    (x || g || Gn(l),
                        (S.effects = []),
                        y && t && t.pendingBranch && v === t.pendingId && (t.deps--, 0 !== t.deps || n || t.resolve()),
                        la(r, 'onResolve'));
                },
                fallback(e) {
                    if (!S.pendingBranch) return;
                    const { vnode: t, activeBranch: n, parentComponent: r, container: o, namespace: i } = S;
                    la(t, 'onFallback');
                    const s = h(n),
                        c = () => {
                            S.isInFallback && (u(null, e, o, s, r, null, i, a, l), fa(S, e));
                        },
                        d = e.transition && 'out-in' === e.transition.mode;
                    (d && (n.transition.afterLeave = c), (S.isInFallback = !0), f(n, r, null, !0), d || c());
                },
                move(e, t, n) {
                    (S.activeBranch && p(S.activeBranch, e, t, n), (S.container = e));
                },
                next: () => S.activeBranch && h(S.activeBranch),
                registerDep(e, t, n) {
                    const r = !!S.pendingBranch;
                    r && S.deps++;
                    const o = e.vnode.el;
                    e.asyncDep
                        .catch(t => {
                            Rn(t, e, 0);
                        })
                        .then(i => {
                            if (e.isUnmounted || S.isUnmounted || S.pendingId !== e.suspenseId) return;
                            e.asyncResolved = !0;
                            const { vnode: a } = e;
                            (Tn(a), ll(e, i, !1), o && (a.el = o));
                            const l = !o && e.subTree.el;
                            (t(e, a, m(o || e.subTree.el), o ? null : h(e.subTree), S, s, n),
                                l && ((a.placeholder = null), g(l)),
                                Ss(e, a.el),
                                Cn(),
                                r && 0 === --S.deps && S.resolve());
                        });
                },
                unmount(e, t) {
                    ((S.isUnmounted = !0),
                        S.activeBranch && f(S.activeBranch, n, e, t),
                        S.pendingBranch && f(S.pendingBranch, n, e, t));
                }
            };
        return S;
    }
    function ua(e) {
        let t;
        if (b(e)) {
            const n = _a && e._c;
            (n && ((e._d = !1), wa()), (e = e()), n && ((e._d = !0), (t = ba), Sa()));
        }
        if (m(e)) {
            const t = gs(e);
            (!t && e.filter(e => e !== ti).length > 0 && En('<Suspense> slots expect a single root node.'), (e = t));
        }
        return ((e = Va(e)), t && !e.dynamicChildren && (e.dynamicChildren = t.filter(t => t !== e)), e);
    }
    function pa(e, t) {
        t && t.pendingBranch ? (m(e) ? t.effects.push(...e) : t.effects.push(e)) : Gn(e);
    }
    function fa(e, t) {
        e.activeBranch = t;
        const { vnode: n, parentComponent: r } = e;
        let o = t.el;
        for (; !o && t.component; ) o = (t = t.component.subTree).el;
        ((n.el = o), r && r.subTree === n && ((r.vnode.el = o), Ss(r, o)));
    }
    const ha = Symbol.for('v-fgt'),
        ma = Symbol.for('v-txt'),
        ga = Symbol.for('v-cmt'),
        va = Symbol.for('v-stc'),
        ya = [];
    let ba = null;
    function wa(e = !1) {
        ya.push((ba = e ? null : []));
    }
    function Sa() {
        (ya.pop(), (ba = ya[ya.length - 1] || null));
    }
    let xa,
        _a = 1;
    function Ta(e, t = !1) {
        ((_a += e), e < 0 && ba && t && (ba.hasOnce = !0));
    }
    function Ca(e) {
        return ((e.dynamicChildren = _a > 0 ? ba || s : null), Sa(), _a > 0 && ba && ba.push(e), e);
    }
    function ka(e, t, n, r, o, i) {
        return Ca(Na(e, t, n, r, o, i, !0));
    }
    function Ea(e, t, n, r, o) {
        return Ca(La(e, t, n, r, o, !0));
    }
    function Aa(e) {
        return !!e && !0 === e.__v_isVNode;
    }
    function Oa(e, t) {
        if (6 & t.shapeFlag && e.component) {
            const n = er.get(t.type);
            if (n && n.has(e.component)) return ((e.shapeFlag &= -257), (t.shapeFlag &= -513), !1);
        }
        return e.type === t.type && e.key === t.key;
    }
    function Ia(e) {
        xa = e;
    }
    const Ma = ({ key: e }) => (null != e ? e : null),
        Pa = ({ ref: e, ref_key: t, ref_for: n }) => (
            'number' == typeof e && (e = '' + e),
            null != e ? (w(e) || Xt(e) || b(e) ? { i: br, r: e, k: t, f: !!n } : e) : null
        );
    function Na(e, t = null, n = null, r = 0, o = null, i = e === ha ? 0 : 1, s = !1, a = !1) {
        const l = {
            __v_isVNode: !0,
            __v_skip: !0,
            type: e,
            props: t,
            key: t && Ma(t),
            ref: t && Pa(t),
            scopeId: wr,
            slotScopeIds: null,
            children: n,
            component: null,
            suspense: null,
            ssContent: null,
            ssFallback: null,
            dirs: null,
            transition: null,
            el: null,
            anchor: null,
            target: null,
            targetStart: null,
            targetAnchor: null,
            staticCount: 0,
            shapeFlag: i,
            patchFlag: r,
            dynamicProps: o,
            dynamicChildren: null,
            appContext: null,
            ctx: br
        };
        return (
            a ? (Ha(l, n), 128 & i && e.normalize(l)) : n && (l.shapeFlag |= w(n) ? 8 : 16),
            l.key != l.key && En('VNode created with invalid key (NaN). VNode type:', l.type),
            _a > 0 && !s && ba && (l.patchFlag > 0 || 6 & i) && 32 !== l.patchFlag && ba.push(l),
            l
        );
    }
    const La = (...e) =>
        (function (e, t = null, n = null, r = 0, o = null, i = !1) {
            if (((e && e !== ti) || (e || En(`Invalid vnode type when creating vnode: ${e}.`), (e = ga)), Aa(e))) {
                const r = $a(e, t, !0);
                return (
                    n && Ha(r, n),
                    _a > 0 && !i && ba && (6 & r.shapeFlag ? (ba[ba.indexOf(e)] = r) : ba.push(r)),
                    (r.patchFlag = -2),
                    r
                );
            }
            if ((bl(e) && (e = e.__vccOpts), t)) {
                t = Ra(t);
                let { class: e, style: n } = t;
                (e && !w(e) && (t.class = Z(e)), x(n) && (qt(n) && !m(n) && (n = u({}, n)), (t.style = Y(n))));
            }
            const s = w(e) ? 1 : ia(e) ? 128 : Ir(e) ? 64 : x(e) ? 4 : b(e) ? 2 : 0;
            return (
                4 & s &&
                    qt(e) &&
                    En(
                        'Vue received a Component that was made a reactive object. This can lead to unnecessary performance overhead and should be avoided by marking the component with `markRaw` or using `shallowRef` instead of `ref`.',
                        '\nComponent that was made reactive: ',
                        (e = Wt(e))
                    ),
                Na(e, t, n, r, o, s, i, !0)
            );
        })(...(xa ? xa(e, br) : e));
    function Ra(e) {
        return e ? (qt(e) || Ts(e) ? u({}, e) : e) : null;
    }
    function $a(e, t, n = !1, r = !1) {
        const { props: o, ref: i, patchFlag: s, children: a, transition: l } = e,
            c = t ? Ua(o || {}, t) : o,
            d = {
                __v_isVNode: !0,
                __v_skip: !0,
                type: e.type,
                props: c,
                key: c && Ma(c),
                ref: t && t.ref ? (n && i ? (m(i) ? i.concat(Pa(t)) : [i, Pa(t)]) : Pa(t)) : i,
                scopeId: e.scopeId,
                slotScopeIds: e.slotScopeIds,
                children: -1 === s && m(a) ? a.map(Ba) : a,
                target: e.target,
                targetStart: e.targetStart,
                targetAnchor: e.targetAnchor,
                staticCount: e.staticCount,
                shapeFlag: e.shapeFlag,
                patchFlag: t && e.type !== ha ? (-1 === s ? 16 : 16 | s) : s,
                dynamicProps: e.dynamicProps,
                dynamicChildren: e.dynamicChildren,
                appContext: e.appContext,
                dirs: e.dirs,
                transition: l,
                component: e.component,
                suspense: e.suspense,
                ssContent: e.ssContent && $a(e.ssContent),
                ssFallback: e.ssFallback && $a(e.ssFallback),
                placeholder: e.placeholder,
                el: e.el,
                anchor: e.anchor,
                ctx: e.ctx,
                ce: e.ce
            };
        return (l && r && Zr(d, l.clone(d)), d);
    }
    function Ba(e) {
        const t = $a(e);
        return (m(e.children) && (t.children = e.children.map(Ba)), t);
    }
    function Fa(e = ' ', t = 0) {
        return La(ma, null, e, t);
    }
    function Da(e, t) {
        const n = La(va, null, e);
        return ((n.staticCount = t), n);
    }
    function ja(e = '', t = !1) {
        return t ? (wa(), Ea(ga, null, e)) : La(ga, null, e);
    }
    function Va(e) {
        return null == e || 'boolean' == typeof e
            ? La(ga)
            : m(e)
              ? La(ha, null, e.slice())
              : Aa(e)
                ? za(e)
                : La(ma, null, String(e));
    }
    function za(e) {
        return (null === e.el && -1 !== e.patchFlag) || e.memo ? e : $a(e);
    }
    function Ha(e, t) {
        let n = 0;
        const { shapeFlag: r } = e;
        if (null == t) t = null;
        else if (m(t)) n = 16;
        else if ('object' == typeof t) {
            if (65 & r) {
                const n = t.default;
                return void (n && (n._c && (n._d = !1), Ha(e, n()), n._c && (n._d = !0)));
            }
            {
                n = 32;
                const r = t._;
                r || Ts(t)
                    ? 3 === r && br && (1 === br.slots._ ? (t._ = 1) : ((t._ = 2), (e.patchFlag |= 1024)))
                    : (t._ctx = br);
            }
        } else
            b(t)
                ? ((t = { default: t, _ctx: br }), (n = 32))
                : ((t = String(t)), 64 & r ? ((n = 16), (t = [Fa(t)])) : (n = 8));
        ((e.children = t), (e.shapeFlag |= n));
    }
    function Ua(...e) {
        const t = {};
        for (let n = 0; n < e.length; n++) {
            const r = e[n];
            for (const e in r)
                if ('class' === e) t.class !== r.class && (t.class = Z([t.class, r.class]));
                else if ('style' === e) t.style = Y([t.style, r.style]);
                else if (c(e)) {
                    const n = t[e],
                        o = r[e];
                    !o || n === o || (m(n) && n.includes(o)) || (t[e] = n ? [].concat(n, o) : o);
                } else '' !== e && (t[e] = r[e]);
        }
        return t;
    }
    function qa(e, t, n, r = null) {
        Ln(e, t, 7, [n, r]);
    }
    const Wa = Ui();
    let Ga = 0;
    function Ya(e, t, n) {
        const r = e.type,
            o = (t ? t.appContext : e.appContext) || Wa,
            s = {
                uid: Ga++,
                vnode: e,
                type: r,
                parent: t,
                appContext: o,
                root: null,
                next: null,
                subTree: null,
                effect: null,
                update: null,
                job: null,
                scope: new _e(!0),
                render: null,
                proxy: null,
                exposed: null,
                exposeProxy: null,
                withProxy: null,
                provides: t ? t.provides : Object.create(o.provides),
                ids: t ? t.ids : ['', 0, 0],
                accessCache: null,
                renderCache: [],
                components: null,
                directives: null,
                propsOptions: As(r, o),
                emitsOptions: ds(r, o),
                emit: null,
                emitted: null,
                propsDefaults: i,
                inheritAttrs: r.inheritAttrs,
                ctx: i,
                data: i,
                props: i,
                attrs: i,
                slots: i,
                refs: i,
                setupState: i,
                setupContext: null,
                suspense: n,
                suspenseId: n ? n.pendingId : 0,
                asyncDep: null,
                asyncResolved: !1,
                isMounted: !1,
                isUnmounted: !1,
                isDeactivated: !1,
                bc: null,
                c: null,
                bm: null,
                m: null,
                bu: null,
                u: null,
                um: null,
                bum: null,
                da: null,
                a: null,
                rtg: null,
                rtc: null,
                ec: null,
                sp: null
            };
        return (
            (s.ctx = (function (e) {
                const t = {};
                return (
                    Object.defineProperty(t, '_', { configurable: !0, enumerable: !1, get: () => e }),
                    Object.keys(pi).forEach(n => {
                        Object.defineProperty(t, n, { configurable: !0, enumerable: !1, get: () => pi[n](e), set: a });
                    }),
                    t
                );
            })(s)),
            (s.root = t ? t.root : s),
            (s.emit = ls.bind(null, s)),
            e.ce && e.ce(s),
            s
        );
    }
    let Ka = null;
    const Xa = () => Ka || br;
    let Ja, Qa;
    {
        const e = U(),
            t = (t, n) => {
                let r;
                return (
                    (r = e[t]) || (r = e[t] = []),
                    r.push(n),
                    e => {
                        r.length > 1 ? r.forEach(t => t(e)) : r[0](e);
                    }
                );
            };
        ((Ja = t('__VUE_INSTANCE_SETTERS__', e => (Ka = e))), (Qa = t('__VUE_SSR_SETTERS__', e => (sl = e))));
    }
    const Za = e => {
            const t = Ka;
            return (
                Ja(e),
                e.scope.on(),
                () => {
                    (e.scope.off(), Ja(t));
                }
            );
        },
        el = () => {
            (Ka && Ka.scope.off(), Ja(null));
        },
        tl = o('slot,component');
    function nl(e, { isNativeTag: t }) {
        (tl(e) || t(e)) && En('Do not use built-in or reserved HTML elements as component id: ' + e);
    }
    function rl(e) {
        return 4 & e.vnode.shapeFlag;
    }
    let ol,
        il,
        sl = !1;
    function al(e, t = !1, n = !1) {
        t && Qa(t);
        const { props: r, children: o } = e.vnode,
            i = rl(e);
        (!(function (e, t, n, r = !1) {
            const o = {},
                i = _s();
            ((e.propsDefaults = Object.create(null)), Cs(e, t, o, i));
            for (const t in e.propsOptions[0]) t in o || (o[t] = void 0);
            (Is(t || {}, o, e),
                n ? (e.props = r ? o : Ft(o)) : e.type.props ? (e.props = o) : (e.props = i),
                (e.attrs = i));
        })(e, r, i, t),
            zs(e, o, n || t));
        const s = i
            ? (function (e, t) {
                  const n = e.type;
                  if ((n.name && nl(n.name, e.appContext.config), n.components)) {
                      const t = Object.keys(n.components);
                      for (let n = 0; n < t.length; n++) nl(t[n], e.appContext.config);
                  }
                  if (n.directives) {
                      const e = Object.keys(n.directives);
                      for (let t = 0; t < e.length; t++) kr(e[t]);
                  }
                  (n.compilerOptions &&
                      dl() &&
                      En(
                          '"compilerOptions" is only supported when using a build of Vue that includes the runtime compiler. Since you are using a runtime-only build, the options should be passed via your build tool config instead.'
                      ),
                      (e.accessCache = Object.create(null)),
                      (e.proxy = new Proxy(e.ctx, mi)),
                      (function (e) {
                          const {
                              ctx: t,
                              propsOptions: [n]
                          } = e;
                          n &&
                              Object.keys(n).forEach(n => {
                                  Object.defineProperty(t, n, {
                                      enumerable: !0,
                                      configurable: !0,
                                      get: () => e.props[n],
                                      set: a
                                  });
                              });
                      })(e));
                  const { setup: r } = n;
                  if (r) {
                      qe();
                      const o = (e.setupContext = r.length > 1 ? fl(e) : null),
                          i = Za(e),
                          s = Nn(r, e, 0, [jt(e.props), o]),
                          a = _(s);
                      if ((We(), i(), (!a && !e.sp) || Ao(e) || ro(e), a)) {
                          if ((s.then(el, el), t))
                              return s
                                  .then(n => {
                                      ll(e, n, t);
                                  })
                                  .catch(t => {
                                      Rn(t, e, 0);
                                  });
                          ((e.asyncDep = s),
                              e.suspense ||
                                  En(
                                      `Component <${yl(e, n)}>: setup function returned a promise, but no <Suspense> boundary was found in the parent component tree. A component with async setup() must be nested in a <Suspense> in order to be rendered.`
                                  ));
                      } else ll(e, s, t);
                  } else ul(e, t);
              })(e, t)
            : void 0;
        return (t && Qa(!1), s);
    }
    function ll(e, t, n) {
        (b(t)
            ? e.type.__ssrInlineRender
                ? (e.ssrRender = t)
                : (e.render = t)
            : x(t)
              ? (Aa(t) && En('setup() should not return VNodes directly - return a render function instead.'),
                (e.devtoolsRawSetupState = t),
                (e.setupState = sn(t)),
                (function (e) {
                    const { ctx: t, setupState: n } = e;
                    Object.keys(Wt(n)).forEach(e => {
                        if (!n.__isScriptSetup) {
                            if (fi(e[0]))
                                return void En(
                                    `setup() return property ${JSON.stringify(e)} should not start with "$" or "_" which are reserved prefixes for Vue internals.`
                                );
                            Object.defineProperty(t, e, { enumerable: !0, configurable: !0, get: () => n[e], set: a });
                        }
                    });
                })(e))
              : void 0 !== t && En('setup() should return an object. Received: ' + (null === t ? 'null' : typeof t)),
            ul(e, n));
    }
    function cl(e) {
        ((ol = e),
            (il = e => {
                e.render._rc && (e.withProxy = new Proxy(e.ctx, gi));
            }));
    }
    const dl = () => !ol;
    function ul(e, t, n) {
        const r = e.type;
        if (!e.render) {
            if (!t && ol && !r.render) {
                const t = r.template || $i(e).template;
                if (t) {
                    Ws(e, 'compile');
                    const { isCustomElement: n, compilerOptions: o } = e.appContext.config,
                        { delimiters: i, compilerOptions: s } = r,
                        a = u(u({ isCustomElement: n, delimiters: i }, o), s);
                    ((r.render = ol(t, a)), Gs(e, 'compile'));
                }
            }
            ((e.render = r.render || a), il && il(e));
        }
        {
            const t = Za(e);
            qe();
            try {
                !(function (e) {
                    const t = $i(e),
                        n = e.proxy,
                        r = e.ctx;
                    ((Ni = !1), t.beforeCreate && Li(t.beforeCreate, e, 'bc'));
                    const {
                            data: o,
                            computed: i,
                            methods: s,
                            watch: l,
                            provide: c,
                            inject: d,
                            created: u,
                            beforeMount: p,
                            mounted: f,
                            beforeUpdate: h,
                            updated: g,
                            activated: v,
                            deactivated: y,
                            beforeDestroy: w,
                            beforeUnmount: S,
                            destroyed: T,
                            unmounted: C,
                            render: k,
                            renderTracked: E,
                            renderTriggered: A,
                            errorCaptured: O,
                            serverPrefetch: I,
                            expose: M,
                            inheritAttrs: P,
                            components: N,
                            directives: L,
                            filters: R
                        } = t,
                        $ = (function () {
                            const e = Object.create(null);
                            return (t, n) => {
                                e[n] ? En(`${t} property "${n}" is already defined in ${e[n]}.`) : (e[n] = t);
                            };
                        })();
                    {
                        const [t] = e.propsOptions;
                        if (t) for (const e in t) $('Props', e);
                    }
                    if (
                        (d &&
                            (function (e, t, n = a) {
                                m(e) && (e = ji(e));
                                for (const r in e) {
                                    const o = e[r];
                                    let i;
                                    ((i = x(o)
                                        ? 'default' in o
                                            ? Ki(o.from || r, o.default, !0)
                                            : Ki(o.from || r)
                                        : Ki(o)),
                                        Xt(i)
                                            ? Object.defineProperty(t, r, {
                                                  enumerable: !0,
                                                  configurable: !0,
                                                  get: () => i.value,
                                                  set: e => (i.value = e)
                                              })
                                            : (t[r] = i),
                                        n('Inject', r));
                                }
                            })(d, r, $),
                        s)
                    )
                        for (const e in s) {
                            const t = s[e];
                            b(t)
                                ? (Object.defineProperty(r, e, {
                                      value: t.bind(n),
                                      configurable: !0,
                                      enumerable: !0,
                                      writable: !0
                                  }),
                                  $('Methods', e))
                                : En(
                                      `Method "${e}" has type "${typeof t}" in the component definition. Did you reference the function correctly?`
                                  );
                        }
                    if (o) {
                        b(o) || En('The data option must be a function. Plain object usage is no longer supported.');
                        const t = o.call(n, n);
                        if (
                            (_(t) &&
                                En(
                                    'data() returned a Promise - note data() cannot be async; If you intend to perform data fetching before component renders, use async setup() + <Suspense>.'
                                ),
                            x(t))
                        ) {
                            e.data = Bt(t);
                            for (const e in t)
                                ($('Data', e),
                                    fi(e[0]) ||
                                        Object.defineProperty(r, e, {
                                            configurable: !0,
                                            enumerable: !0,
                                            get: () => t[e],
                                            set: a
                                        }));
                        } else En('data() should return an object.');
                    }
                    if (((Ni = !0), i))
                        for (const e in i) {
                            const t = i[e],
                                o = b(t) ? t.bind(n, n) : b(t.get) ? t.get.bind(n, n) : a;
                            o === a && En(`Computed property "${e}" has no getter.`);
                            const s =
                                    !b(t) && b(t.set)
                                        ? t.set.bind(n)
                                        : () => {
                                              En(`Write operation failed: computed property "${e}" is readonly.`);
                                          },
                                l = wl({ get: o, set: s });
                            (Object.defineProperty(r, e, {
                                enumerable: !0,
                                configurable: !0,
                                get: () => l.value,
                                set: e => (l.value = e)
                            }),
                                $('Computed', e));
                        }
                    if (l) for (const e in l) Ri(l[e], r, n, e);
                    if (c) {
                        const e = b(c) ? c.call(n) : c;
                        Reflect.ownKeys(e).forEach(t => {
                            Yi(t, e[t]);
                        });
                    }
                    function B(e, t) {
                        m(t) ? t.forEach(t => e(t.bind(n))) : t && e(t.bind(n));
                    }
                    if (
                        (u && Li(u, e, 'c'),
                        B(zo, p),
                        B(Ho, f),
                        B(Uo, h),
                        B(qo, g),
                        B(Lo, v),
                        B(Ro, y),
                        B(Jo, O),
                        B(Xo, E),
                        B(Ko, A),
                        B(Wo, S),
                        B(Go, C),
                        B(Yo, I),
                        m(M))
                    )
                        if (M.length) {
                            const t = e.exposed || (e.exposed = {});
                            M.forEach(e => {
                                Object.defineProperty(t, e, { get: () => n[e], set: t => (n[e] = t), enumerable: !0 });
                            });
                        } else e.exposed || (e.exposed = {});
                    (k && e.render === a && (e.render = k),
                        null != P && (e.inheritAttrs = P),
                        N && (e.components = N),
                        L && (e.directives = L),
                        I && ro(e));
                })(e);
            } finally {
                (We(), t());
            }
        }
        r.render ||
            e.render !== a ||
            t ||
            (!ol && r.template
                ? En(
                      'Component provided template option but runtime compilation is not supported in this build of Vue. Configure your bundler to alias "vue" to "vue/dist/vue.esm-bundler.js".'
                  )
                : En('Component is missing template or render function: ', r));
    }
    const pl = {
        get: (e, t) => (fs(), nt(e, 'get', ''), e[t]),
        set: () => (En('setupContext.attrs is readonly.'), !1),
        deleteProperty: () => (En('setupContext.attrs is readonly.'), !1)
    };
    function fl(e) {
        const t = t => {
            if ((e.exposed && En('expose() should be called only once per setup().'), null != t)) {
                let e = typeof t;
                ('object' === e && (m(t) ? (e = 'array') : Xt(t) && (e = 'ref')),
                    'object' !== e && En(`expose() should be passed a plain object, received ${e}.`));
            }
            e.exposed = t || {};
        };
        {
            let n, r;
            return Object.freeze({
                get attrs() {
                    return n || (n = new Proxy(e.attrs, pl));
                },
                get slots() {
                    return (
                        r ||
                        (r = (function (e) {
                            return new Proxy(e.slots, { get: (t, n) => (nt(e, 'get', '$slots'), t[n]) });
                        })(e))
                    );
                },
                get emit() {
                    return (t, ...n) => e.emit(t, ...n);
                },
                expose: t
            });
        }
    }
    function hl(e) {
        return e.exposed
            ? e.exposeProxy ||
                  (e.exposeProxy = new Proxy(sn(Gt(e.exposed)), {
                      get: (t, n) => (n in t ? t[n] : n in pi ? pi[n](e) : void 0),
                      has: (e, t) => t in e || t in pi
                  }))
            : e.proxy;
    }
    const ml = /(?:^|[-_])\w/g,
        gl = e => e.replace(ml, e => e.toUpperCase()).replace(/[-_]/g, '');
    function vl(e, t = !0) {
        return b(e) ? e.displayName || e.name : e.name || (t && e.__name);
    }
    function yl(e, t, n = !1) {
        let r = vl(t);
        if (!r && t.__file) {
            const e = t.__file.match(/([^/\\]+)\.\w+$/);
            e && (r = e[1]);
        }
        if (!r && e) {
            const n = e => {
                for (const n in e) if (e[n] === t) return n;
            };
            r = n(e.components) || (e.parent && n(e.parent.type.components)) || n(e.appContext.components);
        }
        return r ? gl(r) : n ? 'App' : 'Anonymous';
    }
    function bl(e) {
        return b(e) && '__vccOpts' in e;
    }
    const wl = (e, t) => {
        const n = (function (e, t, n = !1) {
            let r, o;
            b(e) ? (r = e) : ((r = e.get), (o = e.set));
            const i = new hn(r, o, n);
            return (t && !n && ((i.onTrack = t.onTrack), (i.onTrigger = t.onTrigger)), i);
        })(e, t, sl);
        {
            const e = Xa();
            e && e.appContext.config.warnRecursiveComputed && (n._warnRecursive = !0);
        }
        return n;
    };
    function Sl(e, t, n) {
        try {
            Ta(-1);
            const r = arguments.length;
            return 2 === r
                ? x(t) && !m(t)
                    ? Aa(t)
                        ? La(e, null, [t])
                        : La(e, t)
                    : La(e, null, t)
                : (r > 3 ? (n = Array.prototype.slice.call(arguments, 2)) : 3 === r && Aa(n) && (n = [n]), La(e, t, n));
        } finally {
            Ta(1);
        }
    }
    function xl() {
        if ('undefined' == typeof window) return;
        const e = { style: 'color:#3ba776' },
            t = { style: 'color:#1677ff' },
            n = { style: 'color:#f5222d' },
            r = { style: 'color:#eb2f96' },
            o = {
                __vue_custom_formatter: !0,
                header(t) {
                    if (!x(t)) return null;
                    if (t.__isVue) return ['div', e, 'VueInstance'];
                    if (Xt(t)) {
                        qe();
                        const r = t.value;
                        return (
                            We(),
                            [
                                'div',
                                {},
                                ['span', e, ((n = t), Ut(n) ? 'ShallowRef' : n.effect ? 'ComputedRef' : 'Ref')],
                                '<',
                                l(r),
                                '>'
                            ]
                        );
                    }
                    var n;
                    return zt(t)
                        ? [
                              'div',
                              {},
                              ['span', e, Ut(t) ? 'ShallowReactive' : 'Reactive'],
                              '<',
                              l(t),
                              '>' + (Ht(t) ? ' (readonly)' : '')
                          ]
                        : Ht(t)
                          ? ['div', {}, ['span', e, Ut(t) ? 'ShallowReadonly' : 'Readonly'], '<', l(t), '>']
                          : null;
                },
                hasBody: e => e && e.__isVue,
                body(e) {
                    if (e && e.__isVue) return ['div', {}, ...s(e.$)];
                }
            };
        function s(e) {
            const t = [];
            (e.type.props && e.props && t.push(a('props', Wt(e.props))),
                e.setupState !== i && t.push(a('setup', e.setupState)),
                e.data !== i && t.push(a('data', Wt(e.data))));
            const n = c(e, 'computed');
            n && t.push(a('computed', n));
            const o = c(e, 'inject');
            return (
                o && t.push(a('injected', o)),
                t.push([
                    'div',
                    {},
                    ['span', { style: r.style + ';opacity:0.66' }, '$ (internal): '],
                    ['object', { object: e }]
                ]),
                t
            );
        }
        function a(e, t) {
            return (
                (t = u({}, t)),
                Object.keys(t).length
                    ? [
                          'div',
                          { style: 'line-height:1.25em;margin-bottom:0.6em' },
                          ['div', { style: 'color:#476582' }, e],
                          [
                              'div',
                              { style: 'padding-left:1.25em' },
                              ...Object.keys(t).map(e => ['div', {}, ['span', r, e + ': '], l(t[e], !1)])
                          ]
                      ]
                    : ['span', {}]
            );
        }
        function l(e, o = !0) {
            return 'number' == typeof e
                ? ['span', t, e]
                : 'string' == typeof e
                  ? ['span', n, JSON.stringify(e)]
                  : 'boolean' == typeof e
                    ? ['span', r, e]
                    : x(e)
                      ? ['object', { object: o ? Wt(e) : e }]
                      : ['span', n, String(e)];
        }
        function c(e, t) {
            const n = e.type;
            if (b(n)) return;
            const r = {};
            for (const o in e.ctx) d(n, o, t) && (r[o] = e.ctx[o]);
            return r;
        }
        function d(e, t, n) {
            const r = e[n];
            return (
                !!((m(r) && r.includes(t)) || (x(r) && t in r)) ||
                !(!e.extends || !d(e.extends, t, n)) ||
                !(!e.mixins || !e.mixins.some(e => d(e, t, n))) ||
                void 0
            );
        }
        window.devtoolsFormatters ? window.devtoolsFormatters.push(o) : (window.devtoolsFormatters = [o]);
    }
    function _l(e, t, n, r) {
        const o = n[r];
        if (o && Tl(o, e)) return o;
        const i = t();
        return ((i.memo = e.slice()), (i.cacheIndex = r), (n[r] = i));
    }
    function Tl(e, t) {
        const n = e.memo;
        if (n.length != t.length) return !1;
        for (let e = 0; e < n.length; e++) if (F(n[e], t[e])) return !1;
        return (_a > 0 && ba && ba.push(e), !0);
    }
    const Cl = '3.5.25',
        kl = En,
        El = Pn,
        Al = sr,
        Ol = dr,
        Il = {
            createComponentInstance: Ya,
            setupComponent: al,
            renderComponentRoot: hs,
            setCurrentRenderingInstance: Sr,
            isVNode: Aa,
            normalizeVNode: Va,
            getComponentPublicInstance: hl,
            ensureValidVNode: ci,
            pushWarningContext: Tn,
            popWarningContext: Cn
        },
        Ml = null,
        Pl = null,
        Nl = null;
    let Ll;
    const Rl = 'undefined' != typeof window && window.trustedTypes;
    if (Rl)
        try {
            Ll = Rl.createPolicy('vue', { createHTML: e => e });
        } catch (e) {
            kl(`Error creating trusted types policy: ${e}`);
        }
    const $l = Ll ? e => Ll.createHTML(e) : e => e,
        Bl = 'undefined' != typeof document ? document : null,
        Fl = Bl && Bl.createElement('template'),
        Dl = {
            insert: (e, t, n) => {
                t.insertBefore(e, n || null);
            },
            remove: e => {
                const t = e.parentNode;
                t && t.removeChild(e);
            },
            createElement: (e, t, n, r) => {
                const o =
                    'svg' === t
                        ? Bl.createElementNS('http://www.w3.org/2000/svg', e)
                        : 'mathml' === t
                          ? Bl.createElementNS('http://www.w3.org/1998/Math/MathML', e)
                          : n
                            ? Bl.createElement(e, { is: n })
                            : Bl.createElement(e);
                return ('select' === e && r && null != r.multiple && o.setAttribute('multiple', r.multiple), o);
            },
            createText: e => Bl.createTextNode(e),
            createComment: e => Bl.createComment(e),
            setText: (e, t) => {
                e.nodeValue = t;
            },
            setElementText: (e, t) => {
                e.textContent = t;
            },
            parentNode: e => e.parentNode,
            nextSibling: e => e.nextSibling,
            querySelector: e => Bl.querySelector(e),
            setScopeId(e, t) {
                e.setAttribute(t, '');
            },
            insertStaticContent(e, t, n, r, o, i) {
                const s = n ? n.previousSibling : t.lastChild;
                if (o && (o === i || o.nextSibling))
                    for (; t.insertBefore(o.cloneNode(!0), n), o !== i && (o = o.nextSibling); );
                else {
                    Fl.innerHTML = $l('svg' === r ? `<svg>${e}</svg>` : 'mathml' === r ? `<math>${e}</math>` : e);
                    const o = Fl.content;
                    if ('svg' === r || 'mathml' === r) {
                        const e = o.firstChild;
                        for (; e.firstChild; ) o.appendChild(e.firstChild);
                        o.removeChild(e);
                    }
                    t.insertBefore(o, n);
                }
                return [s ? s.nextSibling : t.firstChild, n ? n.previousSibling : t.lastChild];
            }
        },
        jl = 'transition',
        Vl = 'animation',
        zl = Symbol('_vtc'),
        Hl = {
            name: String,
            type: String,
            css: { type: Boolean, default: !0 },
            duration: [String, Number, Object],
            enterFromClass: String,
            enterActiveClass: String,
            enterToClass: String,
            appearFromClass: String,
            appearActiveClass: String,
            appearToClass: String,
            leaveFromClass: String,
            leaveActiveClass: String,
            leaveToClass: String
        },
        Ul = u({}, qr, Hl),
        ql = (e => ((e.displayName = 'Transition'), (e.props = Ul), e))((e, { slots: t }) => Sl(Yr, Yl(e), t)),
        Wl = (e, t = []) => {
            m(e) ? e.forEach(e => e(...t)) : e && e(...t);
        },
        Gl = e => !!e && (m(e) ? e.some(e => e.length > 1) : e.length > 1);
    function Yl(e) {
        const t = {};
        for (const n in e) n in Hl || (t[n] = e[n]);
        if (!1 === e.css) return t;
        const {
                name: n = 'v',
                type: r,
                duration: o,
                enterFromClass: i = `${n}-enter-from`,
                enterActiveClass: s = `${n}-enter-active`,
                enterToClass: a = `${n}-enter-to`,
                appearFromClass: l = i,
                appearActiveClass: c = s,
                appearToClass: d = a,
                leaveFromClass: p = `${n}-leave-from`,
                leaveActiveClass: f = `${n}-leave-active`,
                leaveToClass: h = `${n}-leave-to`
            } = e,
            m = (function (e) {
                if (null == e) return null;
                if (x(e)) return [Kl(e.enter), Kl(e.leave)];
                {
                    const t = Kl(e);
                    return [t, t];
                }
            })(o),
            g = m && m[0],
            v = m && m[1],
            {
                onBeforeEnter: y,
                onEnter: b,
                onEnterCancelled: w,
                onLeave: S,
                onLeaveCancelled: _,
                onBeforeAppear: T = y,
                onAppear: C = b,
                onAppearCancelled: k = w
            } = t,
            E = (e, t, n, r) => {
                ((e._enterCancelled = r), Jl(e, t ? d : a), Jl(e, t ? c : s), n && n());
            },
            A = (e, t) => {
                ((e._isLeaving = !1), Jl(e, p), Jl(e, h), Jl(e, f), t && t());
            },
            O = e => (t, n) => {
                const o = e ? C : b,
                    s = () => E(t, e, n);
                (Wl(o, [t, s]),
                    Ql(() => {
                        (Jl(t, e ? l : i), Xl(t, e ? d : a), Gl(o) || ec(t, r, g, s));
                    }));
            };
        return u(t, {
            onBeforeEnter(e) {
                (Wl(y, [e]), Xl(e, i), Xl(e, s));
            },
            onBeforeAppear(e) {
                (Wl(T, [e]), Xl(e, l), Xl(e, c));
            },
            onEnter: O(!1),
            onAppear: O(!0),
            onLeave(e, t) {
                e._isLeaving = !0;
                const n = () => A(e, t);
                (Xl(e, p),
                    e._enterCancelled ? (Xl(e, f), oc(e)) : (oc(e), Xl(e, f)),
                    Ql(() => {
                        e._isLeaving && (Jl(e, p), Xl(e, h), Gl(S) || ec(e, r, v, n));
                    }),
                    Wl(S, [e, n]));
            },
            onEnterCancelled(e) {
                (E(e, !1, void 0, !0), Wl(w, [e]));
            },
            onAppearCancelled(e) {
                (E(e, !0, void 0, !0), Wl(k, [e]));
            },
            onLeaveCancelled(e) {
                (A(e), Wl(_, [e]));
            }
        });
    }
    function Kl(e) {
        const t = z(e);
        return (In(t, '<transition> explicit duration'), t);
    }
    function Xl(e, t) {
        (t.split(/\s+/).forEach(t => t && e.classList.add(t)), (e[zl] || (e[zl] = new Set())).add(t));
    }
    function Jl(e, t) {
        t.split(/\s+/).forEach(t => t && e.classList.remove(t));
        const n = e[zl];
        n && (n.delete(t), n.size || (e[zl] = void 0));
    }
    function Ql(e) {
        requestAnimationFrame(() => {
            requestAnimationFrame(e);
        });
    }
    let Zl = 0;
    function ec(e, t, n, r) {
        const o = (e._endId = ++Zl),
            i = () => {
                o === e._endId && r();
            };
        if (null != n) return setTimeout(i, n);
        const { type: s, timeout: a, propCount: l } = tc(e, t);
        if (!s) return r();
        const c = s + 'end';
        let d = 0;
        const u = () => {
                (e.removeEventListener(c, p), i());
            },
            p = t => {
                t.target === e && ++d >= l && u();
            };
        (setTimeout(() => {
            d < l && u();
        }, a + 1),
            e.addEventListener(c, p));
    }
    function tc(e, t) {
        const n = window.getComputedStyle(e),
            r = e => (n[e] || '').split(', '),
            o = r(`${jl}Delay`),
            i = r(`${jl}Duration`),
            s = nc(o, i),
            a = r(`${Vl}Delay`),
            l = r(`${Vl}Duration`),
            c = nc(a, l);
        let d = null,
            u = 0,
            p = 0;
        return (
            t === jl
                ? s > 0 && ((d = jl), (u = s), (p = i.length))
                : t === Vl
                  ? c > 0 && ((d = Vl), (u = c), (p = l.length))
                  : ((u = Math.max(s, c)),
                    (d = u > 0 ? (s > c ? jl : Vl) : null),
                    (p = d ? (d === jl ? i.length : l.length) : 0)),
            {
                type: d,
                timeout: u,
                propCount: p,
                hasTransform: d === jl && /\b(?:transform|all)(?:,|$)/.test(r(`${jl}Property`).toString())
            }
        );
    }
    function nc(e, t) {
        for (; e.length < t.length; ) e = e.concat(e);
        return Math.max(...t.map((t, n) => rc(t) + rc(e[n])));
    }
    function rc(e) {
        return 'auto' === e ? 0 : 1e3 * Number(e.slice(0, -1).replace(',', '.'));
    }
    function oc(e) {
        return (e ? e.ownerDocument : document).body.offsetHeight;
    }
    const ic = Symbol('_vod'),
        sc = Symbol('_vsh'),
        ac = {
            name: 'show',
            beforeMount(e, { value: t }, { transition: n }) {
                ((e[ic] = 'none' === e.style.display ? '' : e.style.display), n && t ? n.beforeEnter(e) : lc(e, t));
            },
            mounted(e, { value: t }, { transition: n }) {
                n && t && n.enter(e);
            },
            updated(e, { value: t, oldValue: n }, { transition: r }) {
                !t != !n &&
                    (r
                        ? t
                            ? (r.beforeEnter(e), lc(e, !0), r.enter(e))
                            : r.leave(e, () => {
                                  lc(e, !1);
                              })
                        : lc(e, t));
            },
            beforeUnmount(e, { value: t }) {
                lc(e, t);
            }
        };
    function lc(e, t) {
        ((e.style.display = t ? e[ic] : 'none'), (e[sc] = !t));
    }
    const cc = Symbol('CSS_VAR_TEXT');
    function dc(e) {
        const t = Xa();
        if (!t) return void kl('useCssVars is called without current active component instance.');
        const n = (t.ut = (n = e(t.proxy)) => {
            Array.from(document.querySelectorAll(`[data-v-owner="${t.uid}"]`)).forEach(e => pc(e, n));
        });
        t.getCssVars = () => e(t.proxy);
        const r = () => {
            const r = e(t.proxy);
            (t.ce ? pc(t.ce, r) : uc(t.subTree, r), n(r));
        };
        (Uo(() => {
            Gn(r);
        }),
            Ho(() => {
                ns(r, a, { flush: 'post' });
                const e = new MutationObserver(r);
                (e.observe(t.subTree.el.parentNode, { childList: !0 }), Go(() => e.disconnect()));
            }));
    }
    function uc(e, t) {
        if (128 & e.shapeFlag) {
            const n = e.suspense;
            ((e = n.activeBranch),
                n.pendingBranch &&
                    !n.isHydrating &&
                    n.effects.push(() => {
                        uc(n.activeBranch, t);
                    }));
        }
        for (; e.component; ) e = e.component.subTree;
        if (1 & e.shapeFlag && e.el) pc(e.el, t);
        else if (e.type === ha) e.children.forEach(e => uc(e, t));
        else if (e.type === va) {
            let { el: n, anchor: r } = e;
            for (; n && (pc(n, t), n !== r); ) n = n.nextSibling;
        }
    }
    function pc(e, t) {
        if (1 === e.nodeType) {
            const n = e.style;
            let r = '';
            for (const e in t) {
                const o = be(t[e]);
                (n.setProperty(`--${e}`, o), (r += `--${e}: ${o};`));
            }
            n[cc] = r;
        }
    }
    const fc = /(?:^|;)\s*display\s*:/,
        hc = /[^\\];\s*$/,
        mc = /\s*!important$/;
    function gc(e, t, n) {
        if (m(n)) n.forEach(n => gc(e, t, n));
        else if (
            (null == n && (n = ''),
            hc.test(n) && kl(`Unexpected semicolon at the end of '${t}' style value: '${n}'`),
            t.startsWith('--'))
        )
            e.setProperty(t, n);
        else {
            const r = (function (e, t) {
                const n = yc[t];
                if (n) return n;
                let r = N(t);
                if ('filter' !== r && r in e) return (yc[t] = r);
                r = $(r);
                for (let n = 0; n < vc.length; n++) {
                    const o = vc[n] + r;
                    if (o in e) return (yc[t] = o);
                }
                return t;
            })(e, t);
            mc.test(n) ? e.setProperty(R(r), n.replace(mc, ''), 'important') : (e[r] = n);
        }
    }
    const vc = ['Webkit', 'Moz', 'ms'],
        yc = {},
        bc = 'http://www.w3.org/1999/xlink';
    function wc(e, t, n, r, o, i = se(t)) {
        r && t.startsWith('xlink:')
            ? null == n
                ? e.removeAttributeNS(bc, t.slice(6, t.length))
                : e.setAttributeNS(bc, t, n)
            : null == n || (i && !le(n))
              ? e.removeAttribute(t)
              : e.setAttribute(t, i ? '' : S(n) ? String(n) : n);
    }
    function Sc(e, t, n, r, o) {
        if ('innerHTML' === t || 'textContent' === t) return void (null != n && (e[t] = 'innerHTML' === t ? $l(n) : n));
        const i = e.tagName;
        if ('value' === t && 'PROGRESS' !== i && !i.includes('-')) {
            const r = 'OPTION' === i ? e.getAttribute('value') || '' : e.value,
                o = null == n ? ('checkbox' === e.type ? 'on' : '') : String(n);
            return (
                (r === o && '_value' in e) || (e.value = o),
                null == n && e.removeAttribute(t),
                void (e._value = n)
            );
        }
        let s = !1;
        if ('' === n || null == n) {
            const r = typeof e[t];
            'boolean' === r
                ? (n = le(n))
                : null == n && 'string' === r
                  ? ((n = ''), (s = !0))
                  : 'number' === r && ((n = 0), (s = !0));
        }
        try {
            e[t] = n;
        } catch (e) {
            s || kl(`Failed setting prop "${t}" on <${i.toLowerCase()}>: value ${n} is invalid.`, e);
        }
        s && e.removeAttribute(o || t);
    }
    function xc(e, t, n, r) {
        e.addEventListener(t, n, r);
    }
    const _c = Symbol('_vei');
    const Tc = /(?:Once|Passive|Capture)$/;
    let Cc = 0;
    const kc = Promise.resolve(),
        Ec = () => Cc || (kc.then(() => (Cc = 0)), (Cc = Date.now()));
    function Ac(e, t) {
        return b(e) || m(e)
            ? e
            : (kl(
                  `Wrong type passed as event handler to ${t} - did you forget @ or : in front of your prop?\nExpected function or array of functions, received type ${typeof e}.`
              ),
              a);
    }
    const Oc = e => 111 === e.charCodeAt(0) && 110 === e.charCodeAt(1) && e.charCodeAt(2) > 96 && e.charCodeAt(2) < 123,
        Ic = (e, t, n, r, o, i) => {
            const s = 'svg' === o;
            'class' === t
                ? (function (e, t, n) {
                      const r = e[zl];
                      (r && (t = (t ? [t, ...r] : [...r]).join(' ')),
                          null == t ? e.removeAttribute('class') : n ? e.setAttribute('class', t) : (e.className = t));
                  })(e, r, s)
                : 'style' === t
                  ? (function (e, t, n) {
                        const r = e.style,
                            o = w(n);
                        let i = !1;
                        if (n && !o) {
                            if (t)
                                if (w(t))
                                    for (const e of t.split(';')) {
                                        const t = e.slice(0, e.indexOf(':')).trim();
                                        null == n[t] && gc(r, t, '');
                                    }
                                else for (const e in t) null == n[e] && gc(r, e, '');
                            for (const e in n) ('display' === e && (i = !0), gc(r, e, n[e]));
                        } else if (o) {
                            if (t !== n) {
                                const e = r[cc];
                                (e && (n += ';' + e), (r.cssText = n), (i = fc.test(n)));
                            }
                        } else t && e.removeAttribute('style');
                        ic in e && ((e[ic] = i ? r.display : ''), e[sc] && (r.display = 'none'));
                    })(e, n, r)
                  : c(t)
                    ? d(t) ||
                      (function (e, t, n, r, o = null) {
                          const i = e[_c] || (e[_c] = {}),
                              s = i[t];
                          if (r && s) s.value = Ac(r, t);
                          else {
                              const [n, a] = (function (e) {
                                  let t;
                                  if (Tc.test(e)) {
                                      let n;
                                      for (t = {}; (n = e.match(Tc)); )
                                          ((e = e.slice(0, e.length - n[0].length)), (t[n[0].toLowerCase()] = !0));
                                  }
                                  return [':' === e[2] ? e.slice(3) : R(e.slice(2)), t];
                              })(t);
                              if (r) {
                                  const s = (i[t] = (function (e, t) {
                                      const n = e => {
                                          if (e._vts) {
                                              if (e._vts <= n.attached) return;
                                          } else e._vts = Date.now();
                                          Ln(
                                              (function (e, t) {
                                                  if (m(t)) {
                                                      const n = e.stopImmediatePropagation;
                                                      return (
                                                          (e.stopImmediatePropagation = () => {
                                                              (n.call(e), (e._stopped = !0));
                                                          }),
                                                          t.map(e => t => !t._stopped && e && e(t))
                                                      );
                                                  }
                                                  return t;
                                              })(e, n.value),
                                              t,
                                              5,
                                              [e]
                                          );
                                      };
                                      return ((n.value = e), (n.attached = Ec()), n);
                                  })(Ac(r, t), o));
                                  xc(e, n, s, a);
                              } else
                                  s &&
                                      ((function (e, t, n, r) {
                                          e.removeEventListener(t, n, r);
                                      })(e, n, s, a),
                                      (i[t] = void 0));
                          }
                      })(e, t, 0, r, i)
                    : (
                            '.' === t[0]
                                ? ((t = t.slice(1)), 1)
                                : '^' === t[0]
                                  ? ((t = t.slice(1)), 0)
                                  : (function (e, t, n, r) {
                                        if (r)
                                            return (
                                                'innerHTML' === t || 'textContent' === t || !!(t in e && Oc(t) && b(n))
                                            );
                                        if (
                                            'spellcheck' === t ||
                                            'draggable' === t ||
                                            'translate' === t ||
                                            'autocorrect' === t
                                        )
                                            return !1;
                                        if ('sandbox' === t && 'IFRAME' === e.tagName) return !1;
                                        if ('form' === t) return !1;
                                        if ('list' === t && 'INPUT' === e.tagName) return !1;
                                        if ('type' === t && 'TEXTAREA' === e.tagName) return !1;
                                        if ('width' === t || 'height' === t) {
                                            const t = e.tagName;
                                            if ('IMG' === t || 'VIDEO' === t || 'CANVAS' === t || 'SOURCE' === t)
                                                return !1;
                                        }
                                        return (!Oc(t) || !w(n)) && t in e;
                                    })(e, t, r, s)
                        )
                      ? (Sc(e, t, r),
                        e.tagName.includes('-') ||
                            ('value' !== t && 'checked' !== t && 'selected' !== t) ||
                            wc(e, t, r, s, 0, 'value' !== t))
                      : !e._isVueCE || (!/[A-Z]/.test(t) && w(r))
                        ? ('true-value' === t ? (e._trueValue = r) : 'false-value' === t && (e._falseValue = r),
                          wc(e, t, r, s))
                        : Sc(e, N(t), r, 0, t);
        },
        Mc = {};
    function Pc(e, t, n) {
        let r = to(e, t);
        E(r) && (r = u({}, r, t));
        class o extends Rc {
            constructor(e) {
                super(r, e, n);
            }
        }
        return ((o.def = r), o);
    }
    const Nc = (e, t) => Pc(e, t, xd),
        Lc = 'undefined' != typeof HTMLElement ? HTMLElement : class {};
    class Rc extends Lc {
        constructor(e, t = {}, n = Sd) {
            (super(),
                (this._def = e),
                (this._props = t),
                (this._createApp = n),
                (this._isVueCE = !0),
                (this._instance = null),
                (this._app = null),
                (this._nonce = this._def.nonce),
                (this._connected = !1),
                (this._resolved = !1),
                (this._patching = !1),
                (this._dirty = !1),
                (this._numberProps = null),
                (this._styleChildren = new WeakSet()),
                (this._ob = null),
                this.shadowRoot && n !== Sd
                    ? (this._root = this.shadowRoot)
                    : (this.shadowRoot &&
                          kl(
                              'Custom element has pre-rendered declarative shadow root but is not defined as hydratable. Use `defineSSRCustomElement`.'
                          ),
                      !1 !== e.shadowRoot
                          ? (this.attachShadow(u({}, e.shadowRootOptions, { mode: 'open' })),
                            (this._root = this.shadowRoot))
                          : (this._root = this)));
        }
        connectedCallback() {
            if (!this.isConnected) return;
            (this.shadowRoot || this._resolved || this._parseSlots(), (this._connected = !0));
            let e = this;
            for (; (e = e && (e.parentNode || e.host)); )
                if (e instanceof Rc) {
                    this._parent = e;
                    break;
                }
            this._instance ||
                (this._resolved
                    ? this._mount(this._def)
                    : e && e._pendingResolve
                      ? (this._pendingResolve = e._pendingResolve.then(() => {
                            ((this._pendingResolve = void 0), this._resolveDef());
                        }))
                      : this._resolveDef());
        }
        _setParent(e = this._parent) {
            e && ((this._instance.parent = e._instance), this._inheritParentContext(e));
        }
        _inheritParentContext(e = this._parent) {
            e && this._app && Object.setPrototypeOf(this._app._context.provides, e._instance.provides);
        }
        disconnectedCallback() {
            ((this._connected = !1),
                Un(() => {
                    this._connected ||
                        (this._ob && (this._ob.disconnect(), (this._ob = null)),
                        this._app && this._app.unmount(),
                        this._instance && (this._instance.ce = void 0),
                        (this._app = this._instance = null),
                        this._teleportTargets && (this._teleportTargets.clear(), (this._teleportTargets = void 0)));
                }));
        }
        _processMutations(e) {
            for (const t of e) this._setAttr(t.attributeName);
        }
        _resolveDef() {
            if (this._pendingResolve) return;
            for (let e = 0; e < this.attributes.length; e++) this._setAttr(this.attributes[e].name);
            ((this._ob = new MutationObserver(this._processMutations.bind(this))),
                this._ob.observe(this, { attributes: !0 }));
            const e = (e, t = !1) => {
                    ((this._resolved = !0), (this._pendingResolve = void 0));
                    const { props: n, styles: r } = e;
                    let o;
                    if (n && !m(n))
                        for (const e in n) {
                            const t = n[e];
                            (t === Number || (t && t.type === Number)) &&
                                (e in this._props && (this._props[e] = z(this._props[e])),
                                ((o || (o = Object.create(null)))[N(e)] = !0));
                        }
                    ((this._numberProps = o),
                        this._resolveProps(e),
                        this.shadowRoot
                            ? this._applyStyles(r)
                            : r && kl('Custom element style injection is not supported when using shadowRoot: false'),
                        this._mount(e));
                },
                t = this._def.__asyncLoader;
            t
                ? (this._pendingResolve = t().then(t => {
                      ((t.configureApp = this._def.configureApp), e((this._def = t), !0));
                  }))
                : e(this._def);
        }
        _mount(e) {
            (e.name || (e.name = 'VueElement'),
                (this._app = this._createApp(e)),
                this._inheritParentContext(),
                e.configureApp && e.configureApp(this._app),
                (this._app._ceVNode = this._createVNode()),
                this._app.mount(this._root));
            const t = this._instance && this._instance.exposed;
            if (t)
                for (const e in t)
                    h(this, e)
                        ? kl(`Exposed property "${e}" already exists on custom element.`)
                        : Object.defineProperty(this, e, { get: () => nn(t[e]) });
        }
        _resolveProps(e) {
            const { props: t } = e,
                n = m(t) ? t : Object.keys(t || {});
            for (const e of Object.keys(this)) '_' !== e[0] && n.includes(e) && this._setProp(e, this[e]);
            for (const e of n.map(N))
                Object.defineProperty(this, e, {
                    get() {
                        return this._getProp(e);
                    },
                    set(t) {
                        this._setProp(e, t, !0, !this._patching);
                    }
                });
        }
        _setAttr(e) {
            if (e.startsWith('data-v-')) return;
            const t = this.hasAttribute(e);
            let n = t ? this.getAttribute(e) : Mc;
            const r = N(e);
            (t && this._numberProps && this._numberProps[r] && (n = z(n)), this._setProp(r, n, !1, !0));
        }
        _getProp(e) {
            return this._props[e];
        }
        _setProp(e, t, n = !0, r = !1) {
            if (
                t !== this._props[e] &&
                ((this._dirty = !0),
                t === Mc
                    ? delete this._props[e]
                    : ((this._props[e] = t), 'key' === e && this._app && (this._app._ceVNode.key = t)),
                r && this._instance && this._update(),
                n)
            ) {
                const n = this._ob;
                (n && (this._processMutations(n.takeRecords()), n.disconnect()),
                    !0 === t
                        ? this.setAttribute(R(e), '')
                        : 'string' == typeof t || 'number' == typeof t
                          ? this.setAttribute(R(e), t + '')
                          : t || this.removeAttribute(R(e)),
                    n && n.observe(this, { attributes: !0 }));
            }
        }
        _update() {
            const e = this._createVNode();
            (this._app && (e.appContext = this._app._context), bd(e, this._root));
        }
        _createVNode() {
            const e = {};
            this.shadowRoot || (e.onVnodeMounted = e.onVnodeUpdated = this._renderSlots.bind(this));
            const t = La(this._def, u(e, this._props));
            return (
                this._instance ||
                    (t.ce = e => {
                        ((this._instance = e),
                            (e.ce = this),
                            (e.isCE = !0),
                            (e.ceReload = e => {
                                (this._styles &&
                                    (this._styles.forEach(e => this._root.removeChild(e)), (this._styles.length = 0)),
                                    this._applyStyles(e),
                                    (this._instance = null),
                                    this._update());
                            }));
                        const t = (e, t) => {
                            this.dispatchEvent(new CustomEvent(e, E(t[0]) ? u({ detail: t }, t[0]) : { detail: t }));
                        };
                        ((e.emit = (e, ...n) => {
                            (t(e, n), R(e) !== e && t(R(e), n));
                        }),
                            this._setParent());
                    }),
                t
            );
        }
        _applyStyles(e, t) {
            if (!e) return;
            if (t) {
                if (t === this._def || this._styleChildren.has(t)) return;
                this._styleChildren.add(t);
            }
            const n = this._nonce;
            for (let r = e.length - 1; r >= 0; r--) {
                const o = document.createElement('style');
                if ((n && o.setAttribute('nonce', n), (o.textContent = e[r]), this.shadowRoot.prepend(o), t)) {
                    if (t.__hmrId) {
                        this._childStyles || (this._childStyles = new Map());
                        let e = this._childStyles.get(t.__hmrId);
                        (e || this._childStyles.set(t.__hmrId, (e = [])), e.push(o));
                    }
                } else (this._styles || (this._styles = [])).push(o);
            }
        }
        _parseSlots() {
            const e = (this._slots = {});
            let t;
            for (; (t = this.firstChild); ) {
                const n = (1 === t.nodeType && t.getAttribute('slot')) || 'default';
                ((e[n] || (e[n] = [])).push(t), this.removeChild(t));
            }
        }
        _renderSlots() {
            const e = this._getSlots(),
                t = this._instance.type.__scopeId;
            for (let n = 0; n < e.length; n++) {
                const r = e[n],
                    o = r.getAttribute('name') || 'default',
                    i = this._slots[o],
                    s = r.parentNode;
                if (i)
                    for (const e of i) {
                        if (t && 1 === e.nodeType) {
                            const n = t + '-s',
                                r = document.createTreeWalker(e, 1);
                            let o;
                            for (e.setAttribute(n, ''); (o = r.nextNode()); ) o.setAttribute(n, '');
                        }
                        s.insertBefore(e, r);
                    }
                else for (; r.firstChild; ) s.insertBefore(r.firstChild, r);
                s.removeChild(r);
            }
        }
        _getSlots() {
            const e = [this];
            this._teleportTargets && e.push(...this._teleportTargets);
            const t = new Set();
            for (const n of e) {
                const e = n.querySelectorAll('slot');
                for (let n = 0; n < e.length; n++) t.add(e[n]);
            }
            return Array.from(t);
        }
        _injectChildStyle(e) {
            this._applyStyles(e.styles, e);
        }
        _beginPatch() {
            ((this._patching = !0), (this._dirty = !1));
        }
        _endPatch() {
            ((this._patching = !1), this._dirty && this._instance && this._update());
        }
        _removeChildStyle(e) {
            if ((this._styleChildren.delete(e), this._childStyles && e.__hmrId)) {
                const t = this._childStyles.get(e.__hmrId);
                t && (t.forEach(e => this._root.removeChild(e)), (t.length = 0));
            }
        }
    }
    function $c(e) {
        const t = Xa();
        return (
            (t && t.ce) ||
            (kl(
                t
                    ? `${e || 'useHost'} can only be used in components defined via defineCustomElement.`
                    : `${e || 'useHost'} called without an active component instance.`
            ),
            null)
        );
    }
    function Bc() {
        const e = $c('useShadowRoot');
        return e && e.shadowRoot;
    }
    function Fc(e = '$style') {
        {
            const t = Xa();
            if (!t) return (kl('useCssModule must be called inside setup()'), i);
            const n = t.type.__cssModules;
            if (!n) return (kl('Current instance does not have CSS modules injected.'), i);
            return n[e] || (kl(`Current instance does not have CSS module named "${e}".`), i);
        }
    }
    const Dc = new WeakMap(),
        jc = new WeakMap(),
        Vc = Symbol('_moveCb'),
        zc = Symbol('_enterCb'),
        Hc = (e => (delete e.props.mode, e))({
            name: 'TransitionGroup',
            props: u({}, Ul, { tag: String, moveClass: String }),
            setup(e, { slots: t }) {
                const n = Xa(),
                    r = Hr();
                let o, i;
                return (
                    qo(() => {
                        if (!o.length) return;
                        const t = e.moveClass || `${e.name || 'v'}-move`;
                        if (
                            !(function (e, t, n) {
                                const r = e.cloneNode(),
                                    o = e[zl];
                                (o &&
                                    o.forEach(e => {
                                        e.split(/\s+/).forEach(e => e && r.classList.remove(e));
                                    }),
                                    n.split(/\s+/).forEach(e => e && r.classList.add(e)),
                                    (r.style.display = 'none'));
                                const i = 1 === t.nodeType ? t : t.parentNode;
                                i.appendChild(r);
                                const { hasTransform: s } = tc(r);
                                return (i.removeChild(r), s);
                            })(o[0].el, n.vnode.el, t)
                        )
                            return void (o = []);
                        (o.forEach(Uc), o.forEach(qc));
                        const r = o.filter(Wc);
                        (oc(n.vnode.el),
                            r.forEach(e => {
                                const n = e.el,
                                    r = n.style;
                                (Xl(n, t), (r.transform = r.webkitTransform = r.transitionDuration = ''));
                                const o = (n[Vc] = e => {
                                    (e && e.target !== n) ||
                                        (e && !e.propertyName.endsWith('transform')) ||
                                        (n.removeEventListener('transitionend', o), (n[Vc] = null), Jl(n, t));
                                });
                                n.addEventListener('transitionend', o);
                            }),
                            (o = []));
                    }),
                    () => {
                        const s = Wt(e),
                            a = Yl(s);
                        let l = s.tag || ha;
                        if (((o = []), i))
                            for (let e = 0; e < i.length; e++) {
                                const t = i[e];
                                t.el &&
                                    t.el instanceof Element &&
                                    (o.push(t),
                                    Zr(t, Xr(t, a, r, n)),
                                    Dc.set(t, { left: t.el.offsetLeft, top: t.el.offsetTop }));
                            }
                        i = t.default ? eo(t.default()) : [];
                        for (let e = 0; e < i.length; e++) {
                            const t = i[e];
                            null != t.key
                                ? Zr(t, Xr(t, a, r, n))
                                : t.type !== ma && kl('<TransitionGroup> children must be keyed.');
                        }
                        return La(l, null, i);
                    }
                );
            }
        });
    function Uc(e) {
        const t = e.el;
        (t[Vc] && t[Vc](), t[zc] && t[zc]());
    }
    function qc(e) {
        jc.set(e, { left: e.el.offsetLeft, top: e.el.offsetTop });
    }
    function Wc(e) {
        const t = Dc.get(e),
            n = jc.get(e),
            r = t.left - n.left,
            o = t.top - n.top;
        if (r || o) {
            const t = e.el.style;
            return ((t.transform = t.webkitTransform = `translate(${r}px,${o}px)`), (t.transitionDuration = '0s'), e);
        }
    }
    const Gc = e => {
        const t = e.props['onUpdate:modelValue'] || !1;
        return m(t) ? e => D(t, e) : t;
    };
    function Yc(e) {
        e.target.composing = !0;
    }
    function Kc(e) {
        const t = e.target;
        t.composing && ((t.composing = !1), t.dispatchEvent(new Event('input')));
    }
    const Xc = Symbol('_assign');
    function Jc(e, t, n) {
        return (t && (e = e.trim()), n && (e = V(e)), e);
    }
    const Qc = {
            created(e, { modifiers: { lazy: t, trim: n, number: r } }, o) {
                e[Xc] = Gc(o);
                const i = r || (o.props && 'number' === o.props.type);
                (xc(e, t ? 'change' : 'input', t => {
                    t.target.composing || e[Xc](Jc(e.value, n, i));
                }),
                    (n || i) &&
                        xc(e, 'change', () => {
                            e.value = Jc(e.value, n, i);
                        }),
                    t || (xc(e, 'compositionstart', Yc), xc(e, 'compositionend', Kc), xc(e, 'change', Kc)));
            },
            mounted(e, { value: t }) {
                e.value = null == t ? '' : t;
            },
            beforeUpdate(e, { value: t, oldValue: n, modifiers: { lazy: r, trim: o, number: i } }, s) {
                if (((e[Xc] = Gc(s)), e.composing)) return;
                const a = null == t ? '' : t;
                if (((!i && 'number' !== e.type) || /^0\d/.test(e.value) ? e.value : V(e.value)) !== a) {
                    if (document.activeElement === e && 'range' !== e.type) {
                        if (r && t === n) return;
                        if (o && e.value.trim() === a) return;
                    }
                    e.value = a;
                }
            }
        },
        Zc = {
            deep: !0,
            created(e, t, n) {
                ((e[Xc] = Gc(n)),
                    xc(e, 'change', () => {
                        const t = e._modelValue,
                            n = od(e),
                            r = e.checked,
                            o = e[Xc];
                        if (m(t)) {
                            const e = he(t, n),
                                i = -1 !== e;
                            if (r && !i) o(t.concat(n));
                            else if (!r && i) {
                                const n = [...t];
                                (n.splice(e, 1), o(n));
                            }
                        } else if (v(t)) {
                            const e = new Set(t);
                            (r ? e.add(n) : e.delete(n), o(e));
                        } else o(id(e, r));
                    }));
            },
            mounted: ed,
            beforeUpdate(e, t, n) {
                ((e[Xc] = Gc(n)), ed(e, t, n));
            }
        };
    function ed(e, { value: t, oldValue: n }, r) {
        let o;
        if (((e._modelValue = t), m(t))) o = he(t, r.props.value) > -1;
        else if (v(t)) o = t.has(r.props.value);
        else {
            if (t === n) return;
            o = fe(t, id(e, !0));
        }
        e.checked !== o && (e.checked = o);
    }
    const td = {
            created(e, { value: t }, n) {
                ((e.checked = fe(t, n.props.value)),
                    (e[Xc] = Gc(n)),
                    xc(e, 'change', () => {
                        e[Xc](od(e));
                    }));
            },
            beforeUpdate(e, { value: t, oldValue: n }, r) {
                ((e[Xc] = Gc(r)), t !== n && (e.checked = fe(t, r.props.value)));
            }
        },
        nd = {
            deep: !0,
            created(e, { value: t, modifiers: { number: n } }, r) {
                const o = v(t);
                (xc(e, 'change', () => {
                    const t = Array.prototype.filter.call(e.options, e => e.selected).map(e => (n ? V(od(e)) : od(e)));
                    (e[Xc](e.multiple ? (o ? new Set(t) : t) : t[0]),
                        (e._assigning = !0),
                        Un(() => {
                            e._assigning = !1;
                        }));
                }),
                    (e[Xc] = Gc(r)));
            },
            mounted(e, { value: t }) {
                rd(e, t);
            },
            beforeUpdate(e, t, n) {
                e[Xc] = Gc(n);
            },
            updated(e, { value: t }) {
                e._assigning || rd(e, t);
            }
        };
    function rd(e, t) {
        const n = e.multiple,
            r = m(t);
        if (!n || r || v(t)) {
            for (let o = 0, i = e.options.length; o < i; o++) {
                const i = e.options[o],
                    s = od(i);
                if (n)
                    if (r) {
                        const e = typeof s;
                        i.selected =
                            'string' === e || 'number' === e ? t.some(e => String(e) === String(s)) : he(t, s) > -1;
                    } else i.selected = t.has(s);
                else if (fe(od(i), t)) return void (e.selectedIndex !== o && (e.selectedIndex = o));
            }
            n || -1 === e.selectedIndex || (e.selectedIndex = -1);
        } else
            kl(
                `<select multiple v-model> expects an Array or Set value for its binding, but got ${Object.prototype.toString.call(t).slice(8, -1)}.`
            );
    }
    function od(e) {
        return '_value' in e ? e._value : e.value;
    }
    function id(e, t) {
        const n = t ? '_trueValue' : '_falseValue';
        return n in e ? e[n] : t;
    }
    const sd = {
        created(e, t, n) {
            ld(e, t, n, null, 'created');
        },
        mounted(e, t, n) {
            ld(e, t, n, null, 'mounted');
        },
        beforeUpdate(e, t, n, r) {
            ld(e, t, n, r, 'beforeUpdate');
        },
        updated(e, t, n, r) {
            ld(e, t, n, r, 'updated');
        }
    };
    function ad(e, t) {
        switch (e) {
            case 'SELECT':
                return nd;
            case 'TEXTAREA':
                return Qc;
            default:
                switch (t) {
                    case 'checkbox':
                        return Zc;
                    case 'radio':
                        return td;
                    default:
                        return Qc;
                }
        }
    }
    function ld(e, t, n, r, o) {
        const i = ad(e.tagName, n.props && n.props.type)[o];
        i && i(e, t, n, r);
    }
    const cd = ['ctrl', 'shift', 'alt', 'meta'],
        dd = {
            stop: e => e.stopPropagation(),
            prevent: e => e.preventDefault(),
            self: e => e.target !== e.currentTarget,
            ctrl: e => !e.ctrlKey,
            shift: e => !e.shiftKey,
            alt: e => !e.altKey,
            meta: e => !e.metaKey,
            left: e => 'button' in e && 0 !== e.button,
            middle: e => 'button' in e && 1 !== e.button,
            right: e => 'button' in e && 2 !== e.button,
            exact: (e, t) => cd.some(n => e[`${n}Key`] && !t.includes(n))
        },
        ud = (e, t) => {
            const n = e._withMods || (e._withMods = {}),
                r = t.join('.');
            return (
                n[r] ||
                (n[r] = (n, ...r) => {
                    for (let e = 0; e < t.length; e++) {
                        const r = dd[t[e]];
                        if (r && r(n, t)) return;
                    }
                    return e(n, ...r);
                })
            );
        },
        pd = {
            esc: 'escape',
            space: ' ',
            up: 'arrow-up',
            left: 'arrow-left',
            right: 'arrow-right',
            down: 'arrow-down',
            delete: 'backspace'
        },
        fd = (e, t) => {
            const n = e._withKeys || (e._withKeys = {}),
                r = t.join('.');
            return (
                n[r] ||
                (n[r] = n => {
                    if (!('key' in n)) return;
                    const r = R(n.key);
                    return t.some(e => e === r || pd[e] === r) ? e(n) : void 0;
                })
            );
        },
        hd = u({ patchProp: Ic }, Dl);
    let md,
        gd = !1;
    function vd() {
        return md || (md = Xs(hd));
    }
    function yd() {
        return ((md = gd ? md : Js(hd)), (gd = !0), md);
    }
    const bd = (...e) => {
            vd().render(...e);
        },
        wd = (...e) => {
            yd().hydrate(...e);
        },
        Sd = (...e) => {
            const t = vd().createApp(...e);
            (Td(t), Cd(t));
            const { mount: n } = t;
            return (
                (t.mount = e => {
                    const r = kd(e);
                    if (!r) return;
                    const o = t._component;
                    (b(o) || o.render || o.template || (o.template = r.innerHTML),
                        1 === r.nodeType && (r.textContent = ''));
                    const i = n(r, !1, _d(r));
                    return (
                        r instanceof Element && (r.removeAttribute('v-cloak'), r.setAttribute('data-v-app', '')),
                        i
                    );
                }),
                t
            );
        },
        xd = (...e) => {
            const t = yd().createApp(...e);
            (Td(t), Cd(t));
            const { mount: n } = t;
            return (
                (t.mount = e => {
                    const t = kd(e);
                    if (t) return n(t, !0, _d(t));
                }),
                t
            );
        };
    function _d(e) {
        return e instanceof SVGElement
            ? 'svg'
            : 'function' == typeof MathMLElement && e instanceof MathMLElement
              ? 'mathml'
              : void 0;
    }
    function Td(e) {
        Object.defineProperty(e.config, 'isNativeTag', { value: e => te(e) || ne(e) || re(e), writable: !1 });
    }
    function Cd(e) {
        if (dl()) {
            const t = e.config.isCustomElement;
            Object.defineProperty(e.config, 'isCustomElement', {
                get: () => t,
                set() {
                    kl(
                        'The `isCustomElement` config option is deprecated. Use `compilerOptions.isCustomElement` instead.'
                    );
                }
            });
            const n = e.config.compilerOptions,
                r =
                    'The `compilerOptions` config option is only respected when using a build of Vue.js that includes the runtime compiler (aka "full build"). Since you are using the runtime-only build, `compilerOptions` must be passed to `@vue/compiler-dom` in the build setup instead.\n- For vue-loader: pass it via vue-loader\'s `compilerOptions` loader option.\n- For vue-cli: see https://cli.vuejs.org/guide/webpack.html#modifying-options-of-a-loader\n- For vite: pass it via @vitejs/plugin-vue options. See https://github.com/vitejs/vite-plugin-vue/tree/main/packages/plugin-vue#example-for-passing-options-to-vuecompiler-sfc';
            Object.defineProperty(e.config, 'compilerOptions', {
                get: () => (kl(r), n),
                set() {
                    kl(r);
                }
            });
        }
    }
    function kd(e) {
        if (w(e)) {
            const t = document.querySelector(e);
            return (t || kl(`Failed to mount app: mount target selector "${e}" returned null.`), t);
        }
        return (
            window.ShadowRoot &&
                e instanceof window.ShadowRoot &&
                'closed' === e.mode &&
                kl('mounting on a ShadowRoot with `{mode: "closed"}` may lead to unpredictable bugs'),
            e
        );
    }
    let Ed = !1;
    const Ad = () => {
            Ed ||
                ((Ed = !0),
                (Qc.getSSRProps = ({ value: e }) => ({ value: e })),
                (td.getSSRProps = ({ value: e }, t) => {
                    if (t.props && fe(t.props.value, e)) return { checked: !0 };
                }),
                (Zc.getSSRProps = ({ value: e }, t) => {
                    if (m(e)) {
                        if (t.props && he(e, t.props.value) > -1) return { checked: !0 };
                    } else if (v(e)) {
                        if (t.props && e.has(t.props.value)) return { checked: !0 };
                    } else if (e) return { checked: !0 };
                }),
                (sd.getSSRProps = (e, t) => {
                    if ('string' != typeof t.type) return;
                    const n = ad(t.type.toUpperCase(), t.props && t.props.type);
                    return n.getSSRProps ? n.getSSRProps(e, t) : void 0;
                }),
                (ac.getSSRProps = ({ value: e }) => {
                    if (!e) return { style: { display: 'none' } };
                }));
        },
        Od = Symbol('Fragment'),
        Id = Symbol('Teleport'),
        Md = Symbol('Suspense'),
        Pd = Symbol('KeepAlive'),
        Nd = Symbol('BaseTransition'),
        Ld = Symbol('openBlock'),
        Rd = Symbol('createBlock'),
        $d = Symbol('createElementBlock'),
        Bd = Symbol('createVNode'),
        Fd = Symbol('createElementVNode'),
        Dd = Symbol('createCommentVNode'),
        jd = Symbol('createTextVNode'),
        Vd = Symbol('createStaticVNode'),
        zd = Symbol('resolveComponent'),
        Hd = Symbol('resolveDynamicComponent'),
        Ud = Symbol('resolveDirective'),
        qd = Symbol('resolveFilter'),
        Wd = Symbol('withDirectives'),
        Gd = Symbol('renderList'),
        Yd = Symbol('renderSlot'),
        Kd = Symbol('createSlots'),
        Xd = Symbol('toDisplayString'),
        Jd = Symbol('mergeProps'),
        Qd = Symbol('normalizeClass'),
        Zd = Symbol('normalizeStyle'),
        eu = Symbol('normalizeProps'),
        tu = Symbol('guardReactiveProps'),
        nu = Symbol('toHandlers'),
        ru = Symbol('camelize'),
        ou = Symbol('capitalize'),
        iu = Symbol('toHandlerKey'),
        su = Symbol('setBlockTracking'),
        au = Symbol('pushScopeId'),
        lu = Symbol('popScopeId'),
        cu = Symbol('withCtx'),
        du = Symbol('unref'),
        uu = Symbol('isRef'),
        pu = Symbol('withMemo'),
        fu = Symbol('isMemoSame'),
        hu = {
            [Od]: 'Fragment',
            [Id]: 'Teleport',
            [Md]: 'Suspense',
            [Pd]: 'KeepAlive',
            [Nd]: 'BaseTransition',
            [Ld]: 'openBlock',
            [Rd]: 'createBlock',
            [$d]: 'createElementBlock',
            [Bd]: 'createVNode',
            [Fd]: 'createElementVNode',
            [Dd]: 'createCommentVNode',
            [jd]: 'createTextVNode',
            [Vd]: 'createStaticVNode',
            [zd]: 'resolveComponent',
            [Hd]: 'resolveDynamicComponent',
            [Ud]: 'resolveDirective',
            [qd]: 'resolveFilter',
            [Wd]: 'withDirectives',
            [Gd]: 'renderList',
            [Yd]: 'renderSlot',
            [Kd]: 'createSlots',
            [Xd]: 'toDisplayString',
            [Jd]: 'mergeProps',
            [Qd]: 'normalizeClass',
            [Zd]: 'normalizeStyle',
            [eu]: 'normalizeProps',
            [tu]: 'guardReactiveProps',
            [nu]: 'toHandlers',
            [ru]: 'camelize',
            [ou]: 'capitalize',
            [iu]: 'toHandlerKey',
            [su]: 'setBlockTracking',
            [au]: 'pushScopeId',
            [lu]: 'popScopeId',
            [cu]: 'withCtx',
            [du]: 'unref',
            [uu]: 'isRef',
            [pu]: 'withMemo',
            [fu]: 'isMemoSame'
        },
        mu = { start: { line: 1, column: 1, offset: 0 }, end: { line: 1, column: 1, offset: 0 }, source: '' };
    function gu(e, t, n, r, o, i, s, a = !1, l = !1, c = !1, d = mu) {
        return (
            e && (a ? (e.helper(Ld), e.helper(ku(e.inSSR, c))) : e.helper(Cu(e.inSSR, c)), s && e.helper(Wd)),
            {
                type: 13,
                tag: t,
                props: n,
                children: r,
                patchFlag: o,
                dynamicProps: i,
                directives: s,
                isBlock: a,
                disableTracking: l,
                isComponent: c,
                loc: d
            }
        );
    }
    function vu(e, t = mu) {
        return { type: 17, loc: t, elements: e };
    }
    function yu(e, t = mu) {
        return { type: 15, loc: t, properties: e };
    }
    function bu(e, t) {
        return { type: 16, loc: mu, key: w(e) ? wu(e, !0) : e, value: t };
    }
    function wu(e, t = !1, n = mu, r = 0) {
        return { type: 4, loc: n, content: e, isStatic: t, constType: t ? 3 : r };
    }
    function Su(e, t = mu) {
        return { type: 8, loc: t, children: e };
    }
    function xu(e, t = [], n = mu) {
        return { type: 14, loc: n, callee: e, arguments: t };
    }
    function _u(e, t = void 0, n = !1, r = !1, o = mu) {
        return { type: 18, params: e, returns: t, newline: n, isSlot: r, loc: o };
    }
    function Tu(e, t, n, r = !0) {
        return { type: 19, test: e, consequent: t, alternate: n, newline: r, loc: mu };
    }
    function Cu(e, t) {
        return e || t ? Bd : Fd;
    }
    function ku(e, t) {
        return e || t ? Rd : $d;
    }
    function Eu(e, { helper: t, removeHelper: n, inSSR: r }) {
        e.isBlock || ((e.isBlock = !0), n(Cu(r, e.isComponent)), t(Ld), t(ku(r, e.isComponent)));
    }
    const Au = new Uint8Array([123, 123]),
        Ou = new Uint8Array([125, 125]);
    function Iu(e) {
        return (e >= 97 && e <= 122) || (e >= 65 && e <= 90);
    }
    function Mu(e) {
        return 32 === e || 10 === e || 9 === e || 12 === e || 13 === e;
    }
    function Pu(e) {
        return 47 === e || 62 === e || Mu(e);
    }
    function Nu(e) {
        const t = new Uint8Array(e.length);
        for (let n = 0; n < e.length; n++) t[n] = e.charCodeAt(n);
        return t;
    }
    const Lu = {
            Cdata: new Uint8Array([67, 68, 65, 84, 65, 91]),
            CdataEnd: new Uint8Array([93, 93, 62]),
            CommentEnd: new Uint8Array([45, 45, 62]),
            ScriptEnd: new Uint8Array([60, 47, 115, 99, 114, 105, 112, 116]),
            StyleEnd: new Uint8Array([60, 47, 115, 116, 121, 108, 101]),
            TitleEnd: new Uint8Array([60, 47, 116, 105, 116, 108, 101]),
            TextareaEnd: new Uint8Array([60, 47, 116, 101, 120, 116, 97, 114, 101, 97])
        },
        Ru = {
            COMPILER_IS_ON_ELEMENT: {
                message:
                    'Platform-native elements with "is" prop will no longer be treated as components in Vue 3 unless the "is" value is explicitly prefixed with "vue:".',
                link: 'https://v3-migration.vuejs.org/breaking-changes/custom-elements-interop.html'
            },
            COMPILER_V_BIND_SYNC: {
                message: e =>
                    `.sync modifier for v-bind has been removed. Use v-model with argument instead. \`v-bind:${e}.sync\` should be changed to \`v-model:${e}\`.`,
                link: 'https://v3-migration.vuejs.org/breaking-changes/v-model.html'
            },
            COMPILER_V_BIND_OBJECT_ORDER: {
                message:
                    'v-bind="obj" usage is now order sensitive and behaves like JavaScript object spread: it will now overwrite an existing non-mergeable attribute that appears before v-bind in the case of conflict. To retain 2.x behavior, move v-bind to make it the first attribute. You can also suppress this warning if the usage is intended.',
                link: 'https://v3-migration.vuejs.org/breaking-changes/v-bind.html'
            },
            COMPILER_V_ON_NATIVE: {
                message: '.native modifier for v-on has been removed as is no longer necessary.',
                link: 'https://v3-migration.vuejs.org/breaking-changes/v-on-native-modifier-removed.html'
            },
            COMPILER_V_IF_V_FOR_PRECEDENCE: {
                message:
                    'v-if / v-for precedence when used on the same element has changed in Vue 3: v-if now takes higher precedence and will no longer have access to v-for scope variables. It is best to avoid the ambiguity with <template> tags or use a computed property that filters v-for data source.',
                link: 'https://v3-migration.vuejs.org/breaking-changes/v-if-v-for.html'
            },
            COMPILER_NATIVE_TEMPLATE: {
                message:
                    '<template> with no special directives will render as a native template element instead of its inner content in Vue 3.'
            },
            COMPILER_INLINE_TEMPLATE: {
                message: '"inline-template" has been removed in Vue 3.',
                link: 'https://v3-migration.vuejs.org/breaking-changes/inline-template-attribute.html'
            },
            COMPILER_FILTERS: {
                message:
                    'filters have been removed in Vue 3. The "|" symbol will be treated as native JavaScript bitwise OR operator. Use method calls or computed properties instead.',
                link: 'https://v3-migration.vuejs.org/breaking-changes/filters.html'
            }
        };
    function $u(e, { compatConfig: t }) {
        const n = t && t[e];
        return 'MODE' === e ? n || 3 : n;
    }
    function Bu(e, t) {
        const n = $u('MODE', t),
            r = $u(e, t);
        return 3 === n ? !0 === r : !1 !== r;
    }
    function Fu(e, t, n, ...r) {
        const o = Bu(e, t);
        return (o && Du(e, t, n, ...r), o);
    }
    function Du(e, t, n, ...r) {
        if ('suppress-warning' === $u(e, t)) return;
        const { message: o, link: i } = Ru[e],
            s = `(deprecation ${e}) ${'function' == typeof o ? o(...r) : o}${i ? `\n  Details: ${i}` : ''}`,
            a = new SyntaxError(s);
        ((a.code = e), n && (a.loc = n), t.onWarn(a));
    }
    function ju(e) {
        throw e;
    }
    function Vu(e) {
        console.warn(`[Vue warn] ${e.message}`);
    }
    function zu(e, t, n, r) {
        const o = (n || Hu)[e] + (r || ''),
            i = new SyntaxError(String(o));
        return ((i.code = e), (i.loc = t), i);
    }
    const Hu = {
            0: 'Illegal comment.',
            1: 'CDATA section is allowed only in XML context.',
            2: 'Duplicate attribute.',
            3: 'End tag cannot have attributes.',
            4: "Illegal '/' in tags.",
            5: 'Unexpected EOF in tag.',
            6: 'Unexpected EOF in CDATA section.',
            7: 'Unexpected EOF in comment.',
            8: 'Unexpected EOF in script.',
            9: 'Unexpected EOF in tag.',
            10: 'Incorrectly closed comment.',
            11: 'Incorrectly opened comment.',
            12: "Illegal tag name. Use '&lt;' to print '<'.",
            13: 'Attribute value was expected.',
            14: 'End tag name was expected.',
            15: 'Whitespace was expected.',
            16: "Unexpected '\x3c!--' in comment.",
            17: 'Attribute name cannot contain U+0022 ("), U+0027 (\'), and U+003C (<).',
            18: 'Unquoted attribute value cannot contain U+0022 ("), U+0027 (\'), U+003C (<), U+003D (=), and U+0060 (`).',
            19: "Attribute name cannot start with '='.",
            21: "'<?' is allowed only in XML context.",
            20: 'Unexpected null character.',
            22: "Illegal '/' in tags.",
            23: 'Invalid end tag.',
            24: 'Element is missing end tag.',
            25: 'Interpolation end sign was not found.',
            27: 'End bracket for dynamic directive argument was not found. Note that dynamic directive argument cannot contain spaces.',
            26: 'Legal directive name was expected.',
            28: 'v-if/v-else-if is missing expression.',
            29: 'v-if/else branches must use unique keys.',
            30: 'v-else/v-else-if has no adjacent v-if or v-else-if.',
            31: 'v-for is missing expression.',
            32: 'v-for has invalid expression.',
            33: '<template v-for> key should be placed on the <template> tag.',
            34: 'v-bind is missing expression.',
            52: 'v-bind with same-name shorthand only allows static argument.',
            35: 'v-on is missing expression.',
            36: 'Unexpected custom directive on <slot> outlet.',
            37: 'Mixed v-slot usage on both the component and nested <template>. When there are multiple named slots, all slots should use <template> syntax to avoid scope ambiguity.',
            38: 'Duplicate slot names found. ',
            39: 'Extraneous children found when component already has explicitly named default slot. These children will be ignored.',
            40: 'v-slot can only be used on components or <template> tags.',
            41: 'v-model is missing expression.',
            42: 'v-model value must be a valid JavaScript member expression.',
            43: 'v-model cannot be used on v-for or v-slot scope variables because they are not writable.',
            44: 'v-model cannot be used on a prop, because local prop bindings are not writable.\nUse a v-bind binding combined with a v-on listener that emits update:x event instead.',
            45: 'Error parsing JavaScript expression: ',
            46: '<KeepAlive> expects exactly one child component.',
            51: '@vnode-* hooks in templates are no longer supported. Use the vue: prefix instead. For example, @vnode-mounted should be changed to @vue:mounted. @vnode-* hooks support has been removed in 3.4.',
            47: '"prefixIdentifiers" option is not supported in this build of compiler.',
            48: 'ES module mode is not supported in this build of compiler.',
            49: '"cacheHandlers" option is only supported when the "prefixIdentifiers" option is enabled.',
            50: '"scopeId" option is only supported in module mode.',
            53: ''
        },
        Uu = e => 4 === e.type && e.isStatic;
    function qu(e) {
        switch (e) {
            case 'Teleport':
            case 'teleport':
                return Id;
            case 'Suspense':
            case 'suspense':
                return Md;
            case 'KeepAlive':
            case 'keep-alive':
                return Pd;
            case 'BaseTransition':
            case 'base-transition':
                return Nd;
        }
    }
    const Wu = /^$|^\d|[^\$\w\xA0-\uFFFF]/,
        Gu = e => !Wu.test(e),
        Yu = /[A-Za-z_$\xA0-\uFFFF]/,
        Ku = /[\.\?\w$\xA0-\uFFFF]/,
        Xu = /\s+[.[]\s*|\s*[.[]\s+/g,
        Ju = e => (4 === e.type ? e.content : e.loc.source),
        Qu = e => {
            const t = Ju(e)
                .trim()
                .replace(Xu, e => e.trim());
            let n = 0,
                r = [],
                o = 0,
                i = 0,
                s = null;
            for (let e = 0; e < t.length; e++) {
                const a = t.charAt(e);
                switch (n) {
                    case 0:
                        if ('[' === a) (r.push(n), (n = 1), o++);
                        else if ('(' === a) (r.push(n), (n = 2), i++);
                        else if (!(0 === e ? Yu : Ku).test(a)) return !1;
                        break;
                    case 1:
                        "'" === a || '"' === a || '`' === a
                            ? (r.push(n), (n = 3), (s = a))
                            : '[' === a
                              ? o++
                              : ']' === a && (--o || (n = r.pop()));
                        break;
                    case 2:
                        if ("'" === a || '"' === a || '`' === a) (r.push(n), (n = 3), (s = a));
                        else if ('(' === a) i++;
                        else if (')' === a) {
                            if (e === t.length - 1) return !1;
                            --i || (n = r.pop());
                        }
                        break;
                    case 3:
                        a === s && ((n = r.pop()), (s = null));
                }
            }
            return !o && !i;
        },
        Zu = /^\s*(?:async\s*)?(?:\([^)]*?\)|[\w$_]+)\s*(?::[^=]+)?=>|^\s*(?:async\s+)?function(?:\s+[\w$]+)?\s*\(/;
    function ep(e, t) {
        if (!e) throw new Error(t || 'unexpected compiler condition');
    }
    function tp(e, t, n = !1) {
        for (let r = 0; r < e.props.length; r++) {
            const o = e.props[r];
            if (7 === o.type && (n || o.exp) && (w(t) ? o.name === t : t.test(o.name))) return o;
        }
    }
    function np(e, t, n = !1, r = !1) {
        for (let o = 0; o < e.props.length; o++) {
            const i = e.props[o];
            if (6 === i.type) {
                if (n) continue;
                if (i.name === t && (i.value || r)) return i;
            } else if ('bind' === i.name && (i.exp || r) && rp(i.arg, t)) return i;
        }
    }
    function rp(e, t) {
        return !(!e || !Uu(e) || e.content !== t);
    }
    function op(e) {
        return 5 === e.type || 2 === e.type;
    }
    function ip(e) {
        return 7 === e.type && 'pre' === e.name;
    }
    function sp(e) {
        return 7 === e.type && 'slot' === e.name;
    }
    function ap(e) {
        return 1 === e.type && 3 === e.tagType;
    }
    function lp(e) {
        return 1 === e.type && 2 === e.tagType;
    }
    const cp = new Set([eu, tu]);
    function dp(e, t = []) {
        if (e && !w(e) && 14 === e.type) {
            const n = e.callee;
            if (!w(n) && cp.has(n)) return dp(e.arguments[0], t.concat(e));
        }
        return [e, t];
    }
    function up(e, t, n) {
        let r,
            o,
            i = 13 === e.type ? e.props : e.arguments[2],
            s = [];
        if (i && !w(i) && 14 === i.type) {
            const e = dp(i);
            ((i = e[0]), (s = e[1]), (o = s[s.length - 1]));
        }
        if (null == i || w(i)) r = yu([t]);
        else if (14 === i.type) {
            const e = i.arguments[0];
            (w(e) || 15 !== e.type
                ? i.callee === nu
                    ? (r = xu(n.helper(Jd), [yu([t]), i]))
                    : i.arguments.unshift(yu([t]))
                : pp(t, e) || e.properties.unshift(t),
                !r && (r = i));
        } else
            15 === i.type
                ? (pp(t, i) || i.properties.unshift(t), (r = i))
                : ((r = xu(n.helper(Jd), [yu([t]), i])), o && o.callee === tu && (o = s[s.length - 2]));
        13 === e.type ? (o ? (o.arguments[0] = r) : (e.props = r)) : o ? (o.arguments[0] = r) : (e.arguments[2] = r);
    }
    function pp(e, t) {
        let n = !1;
        if (4 === e.key.type) {
            const r = e.key.content;
            n = t.properties.some(e => 4 === e.key.type && e.key.content === r);
        }
        return n;
    }
    function fp(e, t) {
        return `_${t}_${e.replace(/[^\w]/g, (t, n) => ('-' === t ? '_' : e.charCodeAt(n).toString()))}`;
    }
    const hp = /([\s\S]*?)\s+(?:in|of)\s+(\S[\s\S]*)/;
    function mp(e) {
        for (let t = 0; t < e.length; t++) if (!Mu(e.charCodeAt(t))) return !1;
        return !0;
    }
    function gp(e) {
        return (2 === e.type && mp(e.content)) || (12 === e.type && gp(e.content));
    }
    function vp(e) {
        return 3 === e.type || gp(e);
    }
    const yp = {
        parseMode: 'base',
        ns: 0,
        delimiters: ['{{', '}}'],
        getNamespace: () => 0,
        isVoidTag: l,
        isPreTag: l,
        isIgnoreNewlineTag: l,
        isCustomElement: l,
        onError: ju,
        onWarn: Vu,
        comments: !0,
        prefixIdentifiers: !1
    };
    let bp = yp,
        wp = null,
        Sp = '',
        xp = null,
        _p = null,
        Tp = '',
        Cp = -1,
        kp = -1,
        Ep = 0,
        Ap = !1,
        Op = null;
    const Ip = [],
        Mp = new (class {
            constructor(e, t) {
                ((this.stack = e),
                    (this.cbs = t),
                    (this.state = 1),
                    (this.buffer = ''),
                    (this.sectionStart = 0),
                    (this.index = 0),
                    (this.entityStart = 0),
                    (this.baseState = 1),
                    (this.inRCDATA = !1),
                    (this.inXML = !1),
                    (this.inVPre = !1),
                    (this.newlines = []),
                    (this.mode = 0),
                    (this.delimiterOpen = Au),
                    (this.delimiterClose = Ou),
                    (this.delimiterIndex = -1),
                    (this.currentSequence = void 0),
                    (this.sequenceIndex = 0));
            }
            get inSFCRoot() {
                return 2 === this.mode && 0 === this.stack.length;
            }
            reset() {
                ((this.state = 1),
                    (this.mode = 0),
                    (this.buffer = ''),
                    (this.sectionStart = 0),
                    (this.index = 0),
                    (this.baseState = 1),
                    (this.inRCDATA = !1),
                    (this.currentSequence = void 0),
                    (this.newlines.length = 0),
                    (this.delimiterOpen = Au),
                    (this.delimiterClose = Ou));
            }
            getPos(e) {
                let t = 1,
                    n = e + 1;
                for (let r = this.newlines.length - 1; r >= 0; r--) {
                    const o = this.newlines[r];
                    if (e > o) {
                        ((t = r + 2), (n = e - o));
                        break;
                    }
                }
                return { column: n, line: t, offset: e };
            }
            peek() {
                return this.buffer.charCodeAt(this.index + 1);
            }
            stateText(e) {
                60 === e
                    ? (this.index > this.sectionStart && this.cbs.ontext(this.sectionStart, this.index),
                      (this.state = 5),
                      (this.sectionStart = this.index))
                    : this.inVPre ||
                      e !== this.delimiterOpen[0] ||
                      ((this.state = 2), (this.delimiterIndex = 0), this.stateInterpolationOpen(e));
            }
            stateInterpolationOpen(e) {
                if (e === this.delimiterOpen[this.delimiterIndex])
                    if (this.delimiterIndex === this.delimiterOpen.length - 1) {
                        const e = this.index + 1 - this.delimiterOpen.length;
                        (e > this.sectionStart && this.cbs.ontext(this.sectionStart, e),
                            (this.state = 3),
                            (this.sectionStart = e));
                    } else this.delimiterIndex++;
                else this.inRCDATA ? ((this.state = 32), this.stateInRCDATA(e)) : ((this.state = 1), this.stateText(e));
            }
            stateInterpolation(e) {
                e === this.delimiterClose[0] &&
                    ((this.state = 4), (this.delimiterIndex = 0), this.stateInterpolationClose(e));
            }
            stateInterpolationClose(e) {
                e === this.delimiterClose[this.delimiterIndex]
                    ? this.delimiterIndex === this.delimiterClose.length - 1
                        ? (this.cbs.oninterpolation(this.sectionStart, this.index + 1),
                          this.inRCDATA ? (this.state = 32) : (this.state = 1),
                          (this.sectionStart = this.index + 1))
                        : this.delimiterIndex++
                    : ((this.state = 3), this.stateInterpolation(e));
            }
            stateSpecialStartSequence(e) {
                const t = this.sequenceIndex === this.currentSequence.length;
                if (t ? Pu(e) : (32 | e) === this.currentSequence[this.sequenceIndex]) {
                    if (!t) return void this.sequenceIndex++;
                } else this.inRCDATA = !1;
                ((this.sequenceIndex = 0), (this.state = 6), this.stateInTagName(e));
            }
            stateInRCDATA(e) {
                if (this.sequenceIndex === this.currentSequence.length) {
                    if (62 === e || Mu(e)) {
                        const t = this.index - this.currentSequence.length;
                        if (this.sectionStart < t) {
                            const e = this.index;
                            ((this.index = t), this.cbs.ontext(this.sectionStart, t), (this.index = e));
                        }
                        return ((this.sectionStart = t + 2), this.stateInClosingTagName(e), void (this.inRCDATA = !1));
                    }
                    this.sequenceIndex = 0;
                }
                (32 | e) === this.currentSequence[this.sequenceIndex]
                    ? (this.sequenceIndex += 1)
                    : 0 === this.sequenceIndex
                      ? this.currentSequence === Lu.TitleEnd ||
                        (this.currentSequence === Lu.TextareaEnd && !this.inSFCRoot)
                          ? this.inVPre ||
                            e !== this.delimiterOpen[0] ||
                            ((this.state = 2), (this.delimiterIndex = 0), this.stateInterpolationOpen(e))
                          : this.fastForwardTo(60) && (this.sequenceIndex = 1)
                      : (this.sequenceIndex = Number(60 === e));
            }
            stateCDATASequence(e) {
                e === Lu.Cdata[this.sequenceIndex]
                    ? ++this.sequenceIndex === Lu.Cdata.length &&
                      ((this.state = 28),
                      (this.currentSequence = Lu.CdataEnd),
                      (this.sequenceIndex = 0),
                      (this.sectionStart = this.index + 1))
                    : ((this.sequenceIndex = 0), (this.state = 23), this.stateInDeclaration(e));
            }
            fastForwardTo(e) {
                for (; ++this.index < this.buffer.length; ) {
                    const t = this.buffer.charCodeAt(this.index);
                    if ((10 === t && this.newlines.push(this.index), t === e)) return !0;
                }
                return ((this.index = this.buffer.length - 1), !1);
            }
            stateInCommentLike(e) {
                e === this.currentSequence[this.sequenceIndex]
                    ? ++this.sequenceIndex === this.currentSequence.length &&
                      (this.currentSequence === Lu.CdataEnd
                          ? this.cbs.oncdata(this.sectionStart, this.index - 2)
                          : this.cbs.oncomment(this.sectionStart, this.index - 2),
                      (this.sequenceIndex = 0),
                      (this.sectionStart = this.index + 1),
                      (this.state = 1))
                    : 0 === this.sequenceIndex
                      ? this.fastForwardTo(this.currentSequence[0]) && (this.sequenceIndex = 1)
                      : e !== this.currentSequence[this.sequenceIndex - 1] && (this.sequenceIndex = 0);
            }
            startSpecial(e, t) {
                (this.enterRCDATA(e, t), (this.state = 31));
            }
            enterRCDATA(e, t) {
                ((this.inRCDATA = !0), (this.currentSequence = e), (this.sequenceIndex = t));
            }
            stateBeforeTagName(e) {
                33 === e
                    ? ((this.state = 22), (this.sectionStart = this.index + 1))
                    : 63 === e
                      ? ((this.state = 24), (this.sectionStart = this.index + 1))
                      : Iu(e)
                        ? ((this.sectionStart = this.index),
                          0 === this.mode
                              ? (this.state = 6)
                              : this.inSFCRoot
                                ? (this.state = 34)
                                : this.inXML
                                  ? (this.state = 6)
                                  : (this.state = 116 === e ? 30 : 115 === e ? 29 : 6))
                        : 47 === e
                          ? (this.state = 8)
                          : ((this.state = 1), this.stateText(e));
            }
            stateInTagName(e) {
                Pu(e) && this.handleTagName(e);
            }
            stateInSFCRootTagName(e) {
                if (Pu(e)) {
                    const t = this.buffer.slice(this.sectionStart, this.index);
                    ('template' !== t && this.enterRCDATA(Nu('</' + t), 0), this.handleTagName(e));
                }
            }
            handleTagName(e) {
                (this.cbs.onopentagname(this.sectionStart, this.index),
                    (this.sectionStart = -1),
                    (this.state = 11),
                    this.stateBeforeAttrName(e));
            }
            stateBeforeClosingTagName(e) {
                Mu(e) ||
                    (62 === e
                        ? (this.cbs.onerr(14, this.index), (this.state = 1), (this.sectionStart = this.index + 1))
                        : ((this.state = Iu(e) ? 9 : 27), (this.sectionStart = this.index)));
            }
            stateInClosingTagName(e) {
                (62 === e || Mu(e)) &&
                    (this.cbs.onclosetag(this.sectionStart, this.index),
                    (this.sectionStart = -1),
                    (this.state = 10),
                    this.stateAfterClosingTagName(e));
            }
            stateAfterClosingTagName(e) {
                62 === e && ((this.state = 1), (this.sectionStart = this.index + 1));
            }
            stateBeforeAttrName(e) {
                62 === e
                    ? (this.cbs.onopentagend(this.index),
                      this.inRCDATA ? (this.state = 32) : (this.state = 1),
                      (this.sectionStart = this.index + 1))
                    : 47 === e
                      ? ((this.state = 7), 62 !== this.peek() && this.cbs.onerr(22, this.index))
                      : 60 === e && 47 === this.peek()
                        ? (this.cbs.onopentagend(this.index), (this.state = 5), (this.sectionStart = this.index))
                        : Mu(e) || (61 === e && this.cbs.onerr(19, this.index), this.handleAttrStart(e));
            }
            handleAttrStart(e) {
                118 === e && 45 === this.peek()
                    ? ((this.state = 13), (this.sectionStart = this.index))
                    : 46 === e || 58 === e || 64 === e || 35 === e
                      ? (this.cbs.ondirname(this.index, this.index + 1),
                        (this.state = 14),
                        (this.sectionStart = this.index + 1))
                      : ((this.state = 12), (this.sectionStart = this.index));
            }
            stateInSelfClosingTag(e) {
                62 === e
                    ? (this.cbs.onselfclosingtag(this.index),
                      (this.state = 1),
                      (this.sectionStart = this.index + 1),
                      (this.inRCDATA = !1))
                    : Mu(e) || ((this.state = 11), this.stateBeforeAttrName(e));
            }
            stateInAttrName(e) {
                61 === e || Pu(e)
                    ? (this.cbs.onattribname(this.sectionStart, this.index), this.handleAttrNameEnd(e))
                    : (34 !== e && 39 !== e && 60 !== e) || this.cbs.onerr(17, this.index);
            }
            stateInDirName(e) {
                61 === e || Pu(e)
                    ? (this.cbs.ondirname(this.sectionStart, this.index), this.handleAttrNameEnd(e))
                    : 58 === e
                      ? (this.cbs.ondirname(this.sectionStart, this.index),
                        (this.state = 14),
                        (this.sectionStart = this.index + 1))
                      : 46 === e &&
                        (this.cbs.ondirname(this.sectionStart, this.index),
                        (this.state = 16),
                        (this.sectionStart = this.index + 1));
            }
            stateInDirArg(e) {
                61 === e || Pu(e)
                    ? (this.cbs.ondirarg(this.sectionStart, this.index), this.handleAttrNameEnd(e))
                    : 91 === e
                      ? (this.state = 15)
                      : 46 === e &&
                        (this.cbs.ondirarg(this.sectionStart, this.index),
                        (this.state = 16),
                        (this.sectionStart = this.index + 1));
            }
            stateInDynamicDirArg(e) {
                93 === e
                    ? (this.state = 14)
                    : (61 === e || Pu(e)) &&
                      (this.cbs.ondirarg(this.sectionStart, this.index + 1),
                      this.handleAttrNameEnd(e),
                      this.cbs.onerr(27, this.index));
            }
            stateInDirModifier(e) {
                61 === e || Pu(e)
                    ? (this.cbs.ondirmodifier(this.sectionStart, this.index), this.handleAttrNameEnd(e))
                    : 46 === e &&
                      (this.cbs.ondirmodifier(this.sectionStart, this.index), (this.sectionStart = this.index + 1));
            }
            handleAttrNameEnd(e) {
                ((this.sectionStart = this.index),
                    (this.state = 17),
                    this.cbs.onattribnameend(this.index),
                    this.stateAfterAttrName(e));
            }
            stateAfterAttrName(e) {
                61 === e
                    ? (this.state = 18)
                    : 47 === e || 62 === e
                      ? (this.cbs.onattribend(0, this.sectionStart),
                        (this.sectionStart = -1),
                        (this.state = 11),
                        this.stateBeforeAttrName(e))
                      : Mu(e) || (this.cbs.onattribend(0, this.sectionStart), this.handleAttrStart(e));
            }
            stateBeforeAttrValue(e) {
                34 === e
                    ? ((this.state = 19), (this.sectionStart = this.index + 1))
                    : 39 === e
                      ? ((this.state = 20), (this.sectionStart = this.index + 1))
                      : Mu(e) ||
                        ((this.sectionStart = this.index), (this.state = 21), this.stateInAttrValueNoQuotes(e));
            }
            handleInAttrValue(e, t) {
                (e === t || this.fastForwardTo(t)) &&
                    (this.cbs.onattribdata(this.sectionStart, this.index),
                    (this.sectionStart = -1),
                    this.cbs.onattribend(34 === t ? 3 : 2, this.index + 1),
                    (this.state = 11));
            }
            stateInAttrValueDoubleQuotes(e) {
                this.handleInAttrValue(e, 34);
            }
            stateInAttrValueSingleQuotes(e) {
                this.handleInAttrValue(e, 39);
            }
            stateInAttrValueNoQuotes(e) {
                Mu(e) || 62 === e
                    ? (this.cbs.onattribdata(this.sectionStart, this.index),
                      (this.sectionStart = -1),
                      this.cbs.onattribend(1, this.index),
                      (this.state = 11),
                      this.stateBeforeAttrName(e))
                    : (34 !== e && 39 !== e && 60 !== e && 61 !== e && 96 !== e) || this.cbs.onerr(18, this.index);
            }
            stateBeforeDeclaration(e) {
                91 === e ? ((this.state = 26), (this.sequenceIndex = 0)) : (this.state = 45 === e ? 25 : 23);
            }
            stateInDeclaration(e) {
                (62 === e || this.fastForwardTo(62)) && ((this.state = 1), (this.sectionStart = this.index + 1));
            }
            stateInProcessingInstruction(e) {
                (62 === e || this.fastForwardTo(62)) &&
                    (this.cbs.onprocessinginstruction(this.sectionStart, this.index),
                    (this.state = 1),
                    (this.sectionStart = this.index + 1));
            }
            stateBeforeComment(e) {
                45 === e
                    ? ((this.state = 28),
                      (this.currentSequence = Lu.CommentEnd),
                      (this.sequenceIndex = 2),
                      (this.sectionStart = this.index + 1))
                    : (this.state = 23);
            }
            stateInSpecialComment(e) {
                (62 === e || this.fastForwardTo(62)) &&
                    (this.cbs.oncomment(this.sectionStart, this.index),
                    (this.state = 1),
                    (this.sectionStart = this.index + 1));
            }
            stateBeforeSpecialS(e) {
                e === Lu.ScriptEnd[3]
                    ? this.startSpecial(Lu.ScriptEnd, 4)
                    : e === Lu.StyleEnd[3]
                      ? this.startSpecial(Lu.StyleEnd, 4)
                      : ((this.state = 6), this.stateInTagName(e));
            }
            stateBeforeSpecialT(e) {
                e === Lu.TitleEnd[3]
                    ? this.startSpecial(Lu.TitleEnd, 4)
                    : e === Lu.TextareaEnd[3]
                      ? this.startSpecial(Lu.TextareaEnd, 4)
                      : ((this.state = 6), this.stateInTagName(e));
            }
            startEntity() {}
            stateInEntity() {}
            parse(e) {
                for (this.buffer = e; this.index < this.buffer.length; ) {
                    const e = this.buffer.charCodeAt(this.index);
                    switch ((10 === e && 33 !== this.state && this.newlines.push(this.index), this.state)) {
                        case 1:
                            this.stateText(e);
                            break;
                        case 2:
                            this.stateInterpolationOpen(e);
                            break;
                        case 3:
                            this.stateInterpolation(e);
                            break;
                        case 4:
                            this.stateInterpolationClose(e);
                            break;
                        case 31:
                            this.stateSpecialStartSequence(e);
                            break;
                        case 32:
                            this.stateInRCDATA(e);
                            break;
                        case 26:
                            this.stateCDATASequence(e);
                            break;
                        case 19:
                            this.stateInAttrValueDoubleQuotes(e);
                            break;
                        case 12:
                            this.stateInAttrName(e);
                            break;
                        case 13:
                            this.stateInDirName(e);
                            break;
                        case 14:
                            this.stateInDirArg(e);
                            break;
                        case 15:
                            this.stateInDynamicDirArg(e);
                            break;
                        case 16:
                            this.stateInDirModifier(e);
                            break;
                        case 28:
                            this.stateInCommentLike(e);
                            break;
                        case 27:
                            this.stateInSpecialComment(e);
                            break;
                        case 11:
                            this.stateBeforeAttrName(e);
                            break;
                        case 6:
                            this.stateInTagName(e);
                            break;
                        case 34:
                            this.stateInSFCRootTagName(e);
                            break;
                        case 9:
                            this.stateInClosingTagName(e);
                            break;
                        case 5:
                            this.stateBeforeTagName(e);
                            break;
                        case 17:
                            this.stateAfterAttrName(e);
                            break;
                        case 20:
                            this.stateInAttrValueSingleQuotes(e);
                            break;
                        case 18:
                            this.stateBeforeAttrValue(e);
                            break;
                        case 8:
                            this.stateBeforeClosingTagName(e);
                            break;
                        case 10:
                            this.stateAfterClosingTagName(e);
                            break;
                        case 29:
                            this.stateBeforeSpecialS(e);
                            break;
                        case 30:
                            this.stateBeforeSpecialT(e);
                            break;
                        case 21:
                            this.stateInAttrValueNoQuotes(e);
                            break;
                        case 7:
                            this.stateInSelfClosingTag(e);
                            break;
                        case 23:
                            this.stateInDeclaration(e);
                            break;
                        case 22:
                            this.stateBeforeDeclaration(e);
                            break;
                        case 25:
                            this.stateBeforeComment(e);
                            break;
                        case 24:
                            this.stateInProcessingInstruction(e);
                            break;
                        case 33:
                            this.stateInEntity();
                    }
                    this.index++;
                }
                (this.cleanup(), this.finish());
            }
            cleanup() {
                this.sectionStart !== this.index &&
                    (1 === this.state || (32 === this.state && 0 === this.sequenceIndex)
                        ? (this.cbs.ontext(this.sectionStart, this.index), (this.sectionStart = this.index))
                        : (19 !== this.state && 20 !== this.state && 21 !== this.state) ||
                          (this.cbs.onattribdata(this.sectionStart, this.index), (this.sectionStart = this.index)));
            }
            finish() {
                (this.handleTrailingData(), this.cbs.onend());
            }
            handleTrailingData() {
                const e = this.buffer.length;
                this.sectionStart >= e ||
                    (28 === this.state
                        ? this.currentSequence === Lu.CdataEnd
                            ? this.cbs.oncdata(this.sectionStart, e)
                            : this.cbs.oncomment(this.sectionStart, e)
                        : 6 === this.state ||
                          11 === this.state ||
                          18 === this.state ||
                          17 === this.state ||
                          12 === this.state ||
                          13 === this.state ||
                          14 === this.state ||
                          15 === this.state ||
                          16 === this.state ||
                          20 === this.state ||
                          19 === this.state ||
                          21 === this.state ||
                          9 === this.state ||
                          this.cbs.ontext(this.sectionStart, e));
            }
            emitCodePoint(e, t) {}
        })(Ip, {
            onerr: Xp,
            ontext(e, t) {
                $p(Lp(e, t), e, t);
            },
            ontextentity(e, t, n) {
                $p(e, t, n);
            },
            oninterpolation(e, t) {
                if (Ap) return $p(Lp(e, t), e, t);
                let n = e + Mp.delimiterOpen.length,
                    r = t - Mp.delimiterClose.length;
                for (; Mu(Sp.charCodeAt(n)); ) n++;
                for (; Mu(Sp.charCodeAt(r - 1)); ) r--;
                let o = Lp(n, r);
                (o.includes('&') && (o = bp.decodeEntities(o, !1)),
                    qp({ type: 5, content: Kp(o, !1, Wp(n, r)), loc: Wp(e, t) }));
            },
            onopentagname(e, t) {
                const n = Lp(e, t);
                xp = {
                    type: 1,
                    tag: n,
                    ns: bp.getNamespace(n, Ip[0], bp.ns),
                    tagType: 0,
                    props: [],
                    children: [],
                    loc: Wp(e - 1, t),
                    codegenNode: void 0
                };
            },
            onopentagend(e) {
                Rp(e);
            },
            onclosetag(e, t) {
                const n = Lp(e, t);
                if (!bp.isVoidTag(n)) {
                    let r = !1;
                    for (let e = 0; e < Ip.length; e++)
                        if (Ip[e].tag.toLowerCase() === n.toLowerCase()) {
                            ((r = !0), e > 0 && Xp(24, Ip[0].loc.start.offset));
                            for (let n = 0; n <= e; n++) Bp(Ip.shift(), t, n < e);
                            break;
                        }
                    r || Xp(23, Fp(e, 60));
                }
            },
            onselfclosingtag(e) {
                const t = xp.tag;
                ((xp.isSelfClosing = !0), Rp(e), Ip[0] && Ip[0].tag === t && Bp(Ip.shift(), e));
            },
            onattribname(e, t) {
                _p = { type: 6, name: Lp(e, t), nameLoc: Wp(e, t), value: void 0, loc: Wp(e) };
            },
            ondirname(e, t) {
                const n = Lp(e, t),
                    r = '.' === n || ':' === n ? 'bind' : '@' === n ? 'on' : '#' === n ? 'slot' : n.slice(2);
                if ((Ap || '' !== r || Xp(26, e), Ap || '' === r))
                    _p = { type: 6, name: n, nameLoc: Wp(e, t), value: void 0, loc: Wp(e) };
                else if (
                    ((_p = {
                        type: 7,
                        name: r,
                        rawName: n,
                        exp: void 0,
                        arg: void 0,
                        modifiers: '.' === n ? [wu('prop')] : [],
                        loc: Wp(e)
                    }),
                    'pre' === r)
                ) {
                    ((Ap = Mp.inVPre = !0), (Op = xp));
                    const e = xp.props;
                    for (let t = 0; t < e.length; t++) 7 === e[t].type && (e[t] = Yp(e[t]));
                }
            },
            ondirarg(e, t) {
                if (e === t) return;
                const n = Lp(e, t);
                if (Ap && !ip(_p)) ((_p.name += n), Gp(_p.nameLoc, t));
                else {
                    const r = '[' !== n[0];
                    _p.arg = Kp(r ? n : n.slice(1, -1), r, Wp(e, t), r ? 3 : 0);
                }
            },
            ondirmodifier(e, t) {
                const n = Lp(e, t);
                if (Ap && !ip(_p)) ((_p.name += '.' + n), Gp(_p.nameLoc, t));
                else if ('slot' === _p.name) {
                    const e = _p.arg;
                    e && ((e.content += '.' + n), Gp(e.loc, t));
                } else {
                    const r = wu(n, !0, Wp(e, t));
                    _p.modifiers.push(r);
                }
            },
            onattribdata(e, t) {
                ((Tp += Lp(e, t)), Cp < 0 && (Cp = e), (kp = t));
            },
            onattribentity(e, t, n) {
                ((Tp += e), Cp < 0 && (Cp = t), (kp = n));
            },
            onattribnameend(e) {
                const t = _p.loc.start.offset,
                    n = Lp(t, e);
                (7 === _p.type && (_p.rawName = n),
                    xp.props.some(e => (7 === e.type ? e.rawName : e.name) === n) && Xp(2, t));
            },
            onattribend(e, t) {
                if (xp && _p) {
                    if ((Gp(_p.loc, t), 0 !== e))
                        if ((Tp.includes('&') && (Tp = bp.decodeEntities(Tp, !0)), 6 === _p.type))
                            ('class' === _p.name && (Tp = Up(Tp).trim()),
                                1 !== e || Tp || Xp(13, t),
                                (_p.value = { type: 2, content: Tp, loc: 1 === e ? Wp(Cp, kp) : Wp(Cp - 1, kp + 1) }),
                                Mp.inSFCRoot &&
                                    'template' === xp.tag &&
                                    'lang' === _p.name &&
                                    Tp &&
                                    'html' !== Tp &&
                                    Mp.enterRCDATA(Nu('</template'), 0));
                        else {
                            let e = 0;
                            ((_p.exp = Kp(Tp, !1, Wp(Cp, kp), 0, e)),
                                'for' === _p.name &&
                                    (_p.forParseResult = (function (e) {
                                        const t = e.loc,
                                            n = e.content,
                                            r = n.match(hp);
                                        if (!r) return;
                                        const [, o, i] = r,
                                            s = (e, n, r = !1) => {
                                                const o = t.start.offset + n;
                                                return Kp(e, !1, Wp(o, o + e.length), 0, r ? 1 : 0);
                                            },
                                            a = {
                                                source: s(i.trim(), n.indexOf(i, o.length)),
                                                value: void 0,
                                                key: void 0,
                                                index: void 0,
                                                finalized: !1
                                            };
                                        let l = o.trim().replace(Np, '').trim();
                                        const c = o.indexOf(l),
                                            d = l.match(Pp);
                                        if (d) {
                                            l = l.replace(Pp, '').trim();
                                            const e = d[1].trim();
                                            let t;
                                            if (
                                                (e && ((t = n.indexOf(e, c + l.length)), (a.key = s(e, t, !0))), d[2])
                                            ) {
                                                const r = d[2].trim();
                                                r &&
                                                    (a.index = s(
                                                        r,
                                                        n.indexOf(r, a.key ? t + e.length : c + l.length),
                                                        !0
                                                    ));
                                            }
                                        }
                                        return (l && (a.value = s(l, c, !0)), a);
                                    })(_p.exp)));
                            let t = -1;
                            'bind' === _p.name &&
                                (t = _p.modifiers.findIndex(e => 'sync' === e.content)) > -1 &&
                                Fu('COMPILER_V_BIND_SYNC', bp, _p.loc, _p.arg.loc.source) &&
                                ((_p.name = 'model'), _p.modifiers.splice(t, 1));
                        }
                    (7 === _p.type && 'pre' === _p.name) || xp.props.push(_p);
                }
                ((Tp = ''), (Cp = kp = -1));
            },
            oncomment(e, t) {
                bp.comments && qp({ type: 3, content: Lp(e, t), loc: Wp(e - 4, t + 3) });
            },
            onend() {
                const e = Sp.length;
                if (1 !== Mp.state)
                    switch (Mp.state) {
                        case 5:
                        case 8:
                            Xp(5, e);
                            break;
                        case 3:
                        case 4:
                            Xp(25, Mp.sectionStart);
                            break;
                        case 28:
                            Mp.currentSequence === Lu.CdataEnd ? Xp(6, e) : Xp(7, e);
                            break;
                        case 6:
                        case 7:
                        case 9:
                        case 11:
                        case 12:
                        case 13:
                        case 14:
                        case 15:
                        case 16:
                        case 17:
                        case 18:
                        case 19:
                        case 20:
                        case 21:
                            Xp(9, e);
                    }
                for (let t = 0; t < Ip.length; t++) (Bp(Ip[t], e - 1), Xp(24, Ip[t].loc.start.offset));
            },
            oncdata(e, t) {
                0 !== Ip[0].ns ? $p(Lp(e, t), e, t) : Xp(1, e - 9);
            },
            onprocessinginstruction(e) {
                0 === (Ip[0] ? Ip[0].ns : bp.ns) && Xp(21, e - 1);
            }
        }),
        Pp = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/,
        Np = /^\(|\)$/g;
    function Lp(e, t) {
        return Sp.slice(e, t);
    }
    function Rp(e) {
        (Mp.inSFCRoot && (xp.innerLoc = Wp(e + 1, e + 1)), qp(xp));
        const { tag: t, ns: n } = xp;
        (0 === n && bp.isPreTag(t) && Ep++,
            bp.isVoidTag(t) ? Bp(xp, e) : (Ip.unshift(xp), (1 !== n && 2 !== n) || (Mp.inXML = !0)),
            (xp = null));
    }
    function $p(e, t, n) {
        {
            const t = Ip[0] && Ip[0].tag;
            'script' !== t && 'style' !== t && e.includes('&') && (e = bp.decodeEntities(e, !1));
        }
        const r = Ip[0] || wp,
            o = r.children[r.children.length - 1];
        o && 2 === o.type ? ((o.content += e), Gp(o.loc, n)) : r.children.push({ type: 2, content: e, loc: Wp(t, n) });
    }
    function Bp(e, t, n = !1) {
        (Gp(
            e.loc,
            n
                ? Fp(t, 60)
                : (function (e) {
                      let t = e;
                      for (; 62 !== Sp.charCodeAt(t) && t < Sp.length - 1; ) t++;
                      return t;
                  })(t) + 1
        ),
            Mp.inSFCRoot &&
                (e.children.length
                    ? (e.innerLoc.end = u({}, e.children[e.children.length - 1].loc.end))
                    : (e.innerLoc.end = u({}, e.innerLoc.start)),
                (e.innerLoc.source = Lp(e.innerLoc.start.offset, e.innerLoc.end.offset))));
        const { tag: r, ns: o, children: i } = e;
        if (
            (Ap ||
                ('slot' === r
                    ? (e.tagType = 2)
                    : jp(e)
                      ? (e.tagType = 3)
                      : (function ({ tag: e, props: t }) {
                            if (bp.isCustomElement(e)) return !1;
                            if (
                                'component' === e ||
                                ((n = e.charCodeAt(0)) > 64 && n < 91) ||
                                qu(e) ||
                                (bp.isBuiltInComponent && bp.isBuiltInComponent(e)) ||
                                (bp.isNativeTag && !bp.isNativeTag(e))
                            )
                                return !0;
                            var n;
                            for (let e = 0; e < t.length; e++) {
                                const n = t[e];
                                if (6 === n.type) {
                                    if ('is' === n.name && n.value) {
                                        if (n.value.content.startsWith('vue:')) return !0;
                                        if (Fu('COMPILER_IS_ON_ELEMENT', bp, n.loc)) return !0;
                                    }
                                } else if (
                                    'bind' === n.name &&
                                    rp(n.arg, 'is') &&
                                    Fu('COMPILER_IS_ON_ELEMENT', bp, n.loc)
                                )
                                    return !0;
                            }
                            return !1;
                        })(e) && (e.tagType = 1)),
            Mp.inRCDATA || (e.children = zp(i)),
            0 === o && bp.isIgnoreNewlineTag(r))
        ) {
            const e = i[0];
            e && 2 === e.type && (e.content = e.content.replace(/^\r?\n/, ''));
        }
        (0 === o && bp.isPreTag(r) && Ep--,
            Op === e && ((Ap = Mp.inVPre = !1), (Op = null)),
            Mp.inXML && 0 === (Ip[0] ? Ip[0].ns : bp.ns) && (Mp.inXML = !1));
        {
            const t = e.props;
            if (Bu('COMPILER_V_IF_V_FOR_PRECEDENCE', bp)) {
                let n = !1,
                    r = !1;
                for (let o = 0; o < t.length; o++) {
                    const i = t[o];
                    if ((7 === i.type && ('if' === i.name ? (n = !0) : 'for' === i.name && (r = !0)), n && r)) {
                        Du('COMPILER_V_IF_V_FOR_PRECEDENCE', bp, e.loc);
                        break;
                    }
                }
            }
            if (!Mp.inSFCRoot && Bu('COMPILER_NATIVE_TEMPLATE', bp) && 'template' === e.tag && !jp(e)) {
                Du('COMPILER_NATIVE_TEMPLATE', bp, e.loc);
                const t = Ip[0] || wp,
                    n = t.children.indexOf(e);
                t.children.splice(n, 1, ...e.children);
            }
            const n = t.find(e => 6 === e.type && 'inline-template' === e.name);
            n &&
                Fu('COMPILER_INLINE_TEMPLATE', bp, n.loc) &&
                e.children.length &&
                (n.value = {
                    type: 2,
                    content: Lp(e.children[0].loc.start.offset, e.children[e.children.length - 1].loc.end.offset),
                    loc: n.loc
                });
        }
    }
    function Fp(e, t) {
        let n = e;
        for (; Sp.charCodeAt(n) !== t && n >= 0; ) n--;
        return n;
    }
    const Dp = new Set(['if', 'else', 'else-if', 'for', 'slot']);
    function jp({ tag: e, props: t }) {
        if ('template' === e) for (let e = 0; e < t.length; e++) if (7 === t[e].type && Dp.has(t[e].name)) return !0;
        return !1;
    }
    const Vp = /\r\n/g;
    function zp(e) {
        const t = 'preserve' !== bp.whitespace;
        let n = !1;
        for (let r = 0; r < e.length; r++) {
            const o = e[r];
            if (2 === o.type)
                if (Ep) o.content = o.content.replace(Vp, '\n');
                else if (mp(o.content)) {
                    const i = e[r - 1] && e[r - 1].type,
                        s = e[r + 1] && e[r + 1].type;
                    !i ||
                    !s ||
                    (t && ((3 === i && (3 === s || 1 === s)) || (1 === i && (3 === s || (1 === s && Hp(o.content))))))
                        ? ((n = !0), (e[r] = null))
                        : (o.content = ' ');
                } else t && (o.content = Up(o.content));
        }
        return n ? e.filter(Boolean) : e;
    }
    function Hp(e) {
        for (let t = 0; t < e.length; t++) {
            const n = e.charCodeAt(t);
            if (10 === n || 13 === n) return !0;
        }
        return !1;
    }
    function Up(e) {
        let t = '',
            n = !1;
        for (let r = 0; r < e.length; r++) Mu(e.charCodeAt(r)) ? n || ((t += ' '), (n = !0)) : ((t += e[r]), (n = !1));
        return t;
    }
    function qp(e) {
        (Ip[0] || wp).children.push(e);
    }
    function Wp(e, t) {
        return { start: Mp.getPos(e), end: null == t ? t : Mp.getPos(t), source: null == t ? t : Lp(e, t) };
    }
    function Gp(e, t) {
        ((e.end = Mp.getPos(t)), (e.source = Lp(e.start.offset, t)));
    }
    function Yp(e) {
        const t = {
            type: 6,
            name: e.rawName,
            nameLoc: Wp(e.loc.start.offset, e.loc.start.offset + e.rawName.length),
            value: void 0,
            loc: e.loc
        };
        if (e.exp) {
            const n = e.exp.loc;
            (n.end.offset < e.loc.end.offset && (n.start.offset--, n.start.column--, n.end.offset++, n.end.column++),
                (t.value = { type: 2, content: e.exp.content, loc: n }));
        }
        return t;
    }
    function Kp(e, t = !1, n, r = 0, o = 0) {
        return wu(e, t, n, r);
    }
    function Xp(e, t, n) {
        bp.onError(zu(e, Wp(t, t), void 0, n));
    }
    function Jp(e, t) {
        Zp(e, void 0, t, !!Qp(e));
    }
    function Qp(e) {
        const t = e.children.filter(e => 3 !== e.type);
        return 1 !== t.length || 1 !== t[0].type || lp(t[0]) ? null : t[0];
    }
    function Zp(e, t, n, r = !1, o = !1) {
        const { children: i } = e,
            s = [];
        for (let t = 0; t < i.length; t++) {
            const a = i[t];
            if (1 === a.type && 0 === a.tagType) {
                const e = r ? 0 : ef(a, n);
                if (e > 0) {
                    if (e >= 2) {
                        ((a.codegenNode.patchFlag = -1), s.push(a));
                        continue;
                    }
                } else {
                    const e = a.codegenNode;
                    if (13 === e.type) {
                        const t = e.patchFlag;
                        if ((void 0 === t || 512 === t || 1 === t) && rf(a, n) >= 2) {
                            const t = of(a);
                            t && (e.props = n.hoist(t));
                        }
                        e.dynamicProps && (e.dynamicProps = n.hoist(e.dynamicProps));
                    }
                }
            } else if (12 === a.type && (r ? 0 : ef(a, n)) >= 2) {
                (14 === a.codegenNode.type &&
                    a.codegenNode.arguments.length > 0 &&
                    a.codegenNode.arguments.push(`-1 /* ${q[-1]} */`),
                    s.push(a));
                continue;
            }
            if (1 === a.type) {
                const t = 1 === a.tagType;
                (t && n.scopes.vSlot++, Zp(a, e, n, !1, o), t && n.scopes.vSlot--);
            } else if (11 === a.type) Zp(a, e, n, 1 === a.children.length, !0);
            else if (9 === a.type)
                for (let t = 0; t < a.branches.length; t++)
                    Zp(a.branches[t], e, n, 1 === a.branches[t].children.length, o);
        }
        let a = !1;
        if (s.length === i.length && 1 === e.type)
            if (0 === e.tagType && e.codegenNode && 13 === e.codegenNode.type && m(e.codegenNode.children))
                ((e.codegenNode.children = l(vu(e.codegenNode.children))), (a = !0));
            else if (
                1 === e.tagType &&
                e.codegenNode &&
                13 === e.codegenNode.type &&
                e.codegenNode.children &&
                !m(e.codegenNode.children) &&
                15 === e.codegenNode.children.type
            ) {
                const t = c(e.codegenNode, 'default');
                t && ((t.returns = l(vu(t.returns))), (a = !0));
            } else if (
                3 === e.tagType &&
                t &&
                1 === t.type &&
                1 === t.tagType &&
                t.codegenNode &&
                13 === t.codegenNode.type &&
                t.codegenNode.children &&
                !m(t.codegenNode.children) &&
                15 === t.codegenNode.children.type
            ) {
                const n = tp(e, 'slot', !0),
                    r = n && n.arg && c(t.codegenNode, n.arg);
                r && ((r.returns = l(vu(r.returns))), (a = !0));
            }
        if (!a) for (const e of s) e.codegenNode = n.cache(e.codegenNode);
        function l(e) {
            const t = n.cache(e);
            return ((t.needArraySpread = !0), t);
        }
        function c(e, t) {
            if (e.children && !m(e.children) && 15 === e.children.type) {
                const n = e.children.properties.find(e => e.key === t || e.key.content === t);
                return n && n.value;
            }
        }
        s.length && n.transformHoist && n.transformHoist(i, n, e);
    }
    function ef(e, t) {
        const { constantCache: n } = t;
        switch (e.type) {
            case 1:
                if (0 !== e.tagType) return 0;
                const r = n.get(e);
                if (void 0 !== r) return r;
                const o = e.codegenNode;
                if (13 !== o.type) return 0;
                if (o.isBlock && 'svg' !== e.tag && 'foreignObject' !== e.tag && 'math' !== e.tag) return 0;
                if (void 0 === o.patchFlag) {
                    let r = 3;
                    const i = rf(e, t);
                    if (0 === i) return (n.set(e, 0), 0);
                    i < r && (r = i);
                    for (let o = 0; o < e.children.length; o++) {
                        const i = ef(e.children[o], t);
                        if (0 === i) return (n.set(e, 0), 0);
                        i < r && (r = i);
                    }
                    if (r > 1)
                        for (let o = 0; o < e.props.length; o++) {
                            const i = e.props[o];
                            if (7 === i.type && 'bind' === i.name && i.exp) {
                                const o = ef(i.exp, t);
                                if (0 === o) return (n.set(e, 0), 0);
                                o < r && (r = o);
                            }
                        }
                    if (o.isBlock) {
                        for (let t = 0; t < e.props.length; t++) if (7 === e.props[t].type) return (n.set(e, 0), 0);
                        (t.removeHelper(Ld),
                            t.removeHelper(ku(t.inSSR, o.isComponent)),
                            (o.isBlock = !1),
                            t.helper(Cu(t.inSSR, o.isComponent)));
                    }
                    return (n.set(e, r), r);
                }
                return (n.set(e, 0), 0);
            case 2:
            case 3:
                return 3;
            case 9:
            case 11:
            case 10:
            default:
                return 0;
            case 5:
            case 12:
                return ef(e.content, t);
            case 4:
                return e.constType;
            case 8:
                let i = 3;
                for (let n = 0; n < e.children.length; n++) {
                    const r = e.children[n];
                    if (w(r) || S(r)) continue;
                    const o = ef(r, t);
                    if (0 === o) return 0;
                    o < i && (i = o);
                }
                return i;
            case 20:
                return 2;
        }
    }
    const tf = new Set([Qd, Zd, eu, tu]);
    function nf(e, t) {
        if (14 === e.type && !w(e.callee) && tf.has(e.callee)) {
            const n = e.arguments[0];
            if (4 === n.type) return ef(n, t);
            if (14 === n.type) return nf(n, t);
        }
        return 0;
    }
    function rf(e, t) {
        let n = 3;
        const r = of(e);
        if (r && 15 === r.type) {
            const { properties: e } = r;
            for (let r = 0; r < e.length; r++) {
                const { key: o, value: i } = e[r],
                    s = ef(o, t);
                if (0 === s) return s;
                let a;
                if ((s < n && (n = s), (a = 4 === i.type ? ef(i, t) : 14 === i.type ? nf(i, t) : 0), 0 === a)) return a;
                a < n && (n = a);
            }
        }
        return n;
    }
    function of(e) {
        const t = e.codegenNode;
        if (13 === t.type) return t.props;
    }
    function sf(e, t) {
        const n = (function (
            e,
            {
                filename: t = '',
                prefixIdentifiers: n = !1,
                hoistStatic: r = !1,
                hmr: o = !1,
                cacheHandlers: s = !1,
                nodeTransforms: l = [],
                directiveTransforms: c = {},
                transformHoist: d = null,
                isBuiltInComponent: u = a,
                isCustomElement: p = a,
                expressionPlugins: f = [],
                scopeId: h = null,
                slotted: m = !0,
                ssr: g = !1,
                inSSR: v = !1,
                ssrCssVars: y = '',
                bindingMetadata: b = i,
                inline: S = !1,
                isTS: x = !1,
                onError: _ = ju,
                onWarn: T = Vu,
                compatConfig: C
            }
        ) {
            const k = t.replace(/\?.*$/, '').match(/([^/\\]+)\.\w+$/),
                E = {
                    filename: t,
                    selfName: k && $(N(k[1])),
                    prefixIdentifiers: n,
                    hoistStatic: r,
                    hmr: o,
                    cacheHandlers: s,
                    nodeTransforms: l,
                    directiveTransforms: c,
                    transformHoist: d,
                    isBuiltInComponent: u,
                    isCustomElement: p,
                    expressionPlugins: f,
                    scopeId: h,
                    slotted: m,
                    ssr: g,
                    inSSR: v,
                    ssrCssVars: y,
                    bindingMetadata: b,
                    inline: S,
                    isTS: x,
                    onError: _,
                    onWarn: T,
                    compatConfig: C,
                    root: e,
                    helpers: new Map(),
                    components: new Set(),
                    directives: new Set(),
                    hoists: [],
                    imports: [],
                    cached: [],
                    constantCache: new WeakMap(),
                    temps: 0,
                    identifiers: Object.create(null),
                    scopes: { vFor: 0, vSlot: 0, vPre: 0, vOnce: 0 },
                    parent: null,
                    grandParent: null,
                    currentNode: e,
                    childIndex: 0,
                    inVOnce: !1,
                    helper(e) {
                        const t = E.helpers.get(e) || 0;
                        return (E.helpers.set(e, t + 1), e);
                    },
                    removeHelper(e) {
                        const t = E.helpers.get(e);
                        if (t) {
                            const n = t - 1;
                            n ? E.helpers.set(e, n) : E.helpers.delete(e);
                        }
                    },
                    helperString: e => `_${hu[E.helper(e)]}`,
                    replaceNode(e) {
                        if (!E.currentNode) throw new Error('Node being replaced is already removed.');
                        if (!E.parent) throw new Error('Cannot replace root node.');
                        E.parent.children[E.childIndex] = E.currentNode = e;
                    },
                    removeNode(e) {
                        if (!E.parent) throw new Error('Cannot remove root node.');
                        const t = E.parent.children,
                            n = e ? t.indexOf(e) : E.currentNode ? E.childIndex : -1;
                        if (n < 0) throw new Error('node being removed is not a child of current parent');
                        (e && e !== E.currentNode
                            ? E.childIndex > n && (E.childIndex--, E.onNodeRemoved())
                            : ((E.currentNode = null), E.onNodeRemoved()),
                            E.parent.children.splice(n, 1));
                    },
                    onNodeRemoved: a,
                    addIdentifiers(e) {},
                    removeIdentifiers(e) {},
                    hoist(e) {
                        (w(e) && (e = wu(e)), E.hoists.push(e));
                        const t = wu(`_hoisted_${E.hoists.length}`, !1, e.loc, 2);
                        return ((t.hoisted = e), t);
                    },
                    cache(e, t = !1, n = !1) {
                        const r = (function (e, t, n = !1, r = !1) {
                            return {
                                type: 20,
                                index: e,
                                value: t,
                                needPauseTracking: n,
                                inVOnce: r,
                                needArraySpread: !1,
                                loc: mu
                            };
                        })(E.cached.length, e, t, n);
                        return (E.cached.push(r), r);
                    }
                };
            return ((E.filters = new Set()), E);
        })(e, t);
        (af(e, n),
            t.hoistStatic && Jp(e, n),
            t.ssr ||
                (function (e, t) {
                    const { helper: n } = t,
                        { children: r } = e;
                    if (1 === r.length) {
                        const n = Qp(e);
                        if (n && n.codegenNode) {
                            const r = n.codegenNode;
                            (13 === r.type && Eu(r, t), (e.codegenNode = r));
                        } else e.codegenNode = r[0];
                    } else if (r.length > 1) {
                        let o = 64;
                        (1 === r.filter(e => 3 !== e.type).length && (o |= 2048),
                            (e.codegenNode = gu(t, n(Od), void 0, e.children, o, void 0, void 0, !0, void 0, !1)));
                    }
                })(e, n),
            (e.helpers = new Set([...n.helpers.keys()])),
            (e.components = [...n.components]),
            (e.directives = [...n.directives]),
            (e.imports = n.imports),
            (e.hoists = n.hoists),
            (e.temps = n.temps),
            (e.cached = n.cached),
            (e.transformed = !0),
            (e.filters = [...n.filters]));
    }
    function af(e, t) {
        t.currentNode = e;
        const { nodeTransforms: n } = t,
            r = [];
        for (let o = 0; o < n.length; o++) {
            const i = n[o](e, t);
            if ((i && (m(i) ? r.push(...i) : r.push(i)), !t.currentNode)) return;
            e = t.currentNode;
        }
        switch (e.type) {
            case 3:
                t.ssr || t.helper(Dd);
                break;
            case 5:
                t.ssr || t.helper(Xd);
                break;
            case 9:
                for (let n = 0; n < e.branches.length; n++) af(e.branches[n], t);
                break;
            case 10:
            case 11:
            case 1:
            case 0:
                !(function (e, t) {
                    let n = 0;
                    const r = () => {
                        n--;
                    };
                    for (; n < e.children.length; n++) {
                        const o = e.children[n];
                        w(o) ||
                            ((t.grandParent = t.parent),
                            (t.parent = e),
                            (t.childIndex = n),
                            (t.onNodeRemoved = r),
                            af(o, t));
                    }
                })(e, t);
        }
        t.currentNode = e;
        let o = r.length;
        for (; o--; ) r[o]();
    }
    function lf(e, t) {
        const n = w(e) ? t => t === e : t => e.test(t);
        return (e, r) => {
            if (1 === e.type) {
                const { props: o } = e;
                if (3 === e.tagType && o.some(sp)) return;
                const i = [];
                for (let s = 0; s < o.length; s++) {
                    const a = o[s];
                    if (7 === a.type && n(a.name)) {
                        (o.splice(s, 1), s--);
                        const n = t(e, a, r);
                        n && i.push(n);
                    }
                }
                return i;
            }
        };
    }
    const cf = '/*@__PURE__*/',
        df = e => `${hu[e]}: _${hu[e]}`;
    function uf(e, t, { helper: n, push: r, newline: o, isTS: i }) {
        const s = n('filter' === t ? qd : 'component' === t ? zd : Ud);
        for (let n = 0; n < e.length; n++) {
            let a = e[n];
            const l = a.endsWith('__self');
            (l && (a = a.slice(0, -6)),
                r(`const ${fp(a, t)} = ${s}(${JSON.stringify(a)}${l ? ', true' : ''})${i ? '!' : ''}`),
                n < e.length - 1 && o());
        }
    }
    function pf(e, t) {
        const n =
            e.length > 3 ||
            e.some(
                e =>
                    m(e) ||
                    !(function (e) {
                        return w(e) || 4 === e.type || 2 === e.type || 5 === e.type || 8 === e.type;
                    })(e)
            );
        (t.push('['), n && t.indent(), ff(e, t, n), n && t.deindent(), t.push(']'));
    }
    function ff(e, t, n = !1, r = !0) {
        const { push: o, newline: i } = t;
        for (let s = 0; s < e.length; s++) {
            const a = e[s];
            (w(a) ? o(a, -3) : m(a) ? pf(a, t) : hf(a, t), s < e.length - 1 && (n ? (r && o(','), i()) : r && o(', ')));
        }
    }
    function hf(e, t) {
        if (w(e)) t.push(e, -3);
        else if (S(e)) t.push(t.helper(e));
        else
            switch (e.type) {
                case 1:
                case 9:
                case 11:
                    (ep(
                        null != e.codegenNode,
                        'Codegen node is missing for element/if/for node. Apply appropriate transforms first.'
                    ),
                        hf(e.codegenNode, t));
                    break;
                case 2:
                    !(function (e, t) {
                        t.push(JSON.stringify(e.content), -3, e);
                    })(e, t);
                    break;
                case 4:
                    mf(e, t);
                    break;
                case 5:
                    !(function (e, t) {
                        const { push: n, helper: r, pure: o } = t;
                        (o && n(cf), n(`${r(Xd)}(`), hf(e.content, t), n(')'));
                    })(e, t);
                    break;
                case 12:
                    hf(e.codegenNode, t);
                    break;
                case 8:
                    gf(e, t);
                    break;
                case 3:
                    !(function (e, t) {
                        const { push: n, helper: r, pure: o } = t;
                        (o && n(cf), n(`${r(Dd)}(${JSON.stringify(e.content)})`, -3, e));
                    })(e, t);
                    break;
                case 13:
                    !(function (e, t) {
                        const { push: n, helper: r, pure: o } = t,
                            {
                                tag: i,
                                props: s,
                                children: a,
                                patchFlag: l,
                                dynamicProps: c,
                                directives: d,
                                isBlock: u,
                                disableTracking: p,
                                isComponent: f
                            } = e;
                        let h;
                        if (l)
                            if (l < 0) h = l + ` /* ${q[l]} */`;
                            else {
                                const e = Object.keys(q)
                                    .map(Number)
                                    .filter(e => e > 0 && l & e)
                                    .map(e => q[e])
                                    .join(', ');
                                h = l + ` /* ${e} */`;
                            }
                        (d && n(r(Wd) + '('), u && n(`(${r(Ld)}(${p ? 'true' : ''}), `), o && n(cf));
                        (n(r(u ? ku(t.inSSR, f) : Cu(t.inSSR, f)) + '(', -2, e),
                            ff(
                                (function (e) {
                                    let t = e.length;
                                    for (; t-- && null == e[t]; );
                                    return e.slice(0, t + 1).map(e => e || 'null');
                                })([i, s, a, h, c]),
                                t
                            ),
                            n(')'),
                            u && n(')'),
                            d && (n(', '), hf(d, t), n(')')));
                    })(e, t);
                    break;
                case 14:
                    !(function (e, t) {
                        const { push: n, helper: r, pure: o } = t,
                            i = w(e.callee) ? e.callee : r(e.callee);
                        (o && n(cf), n(i + '(', -2, e), ff(e.arguments, t), n(')'));
                    })(e, t);
                    break;
                case 15:
                    !(function (e, t) {
                        const { push: n, indent: r, deindent: o, newline: i } = t,
                            { properties: s } = e;
                        if (!s.length) return void n('{}', -2, e);
                        const a = s.length > 1 || s.some(e => 4 !== e.value.type);
                        (n(a ? '{' : '{ '), a && r());
                        for (let e = 0; e < s.length; e++) {
                            const { key: r, value: o } = s[e];
                            (vf(r, t), n(': '), hf(o, t), e < s.length - 1 && (n(','), i()));
                        }
                        (a && o(), n(a ? '}' : ' }'));
                    })(e, t);
                    break;
                case 17:
                    !(function (e, t) {
                        pf(e.elements, t);
                    })(e, t);
                    break;
                case 18:
                    !(function (e, t) {
                        const { push: n, indent: r, deindent: o } = t,
                            { params: i, returns: s, body: a, newline: l, isSlot: c } = e;
                        (c && n(`_${hu[cu]}(`),
                            n('(', -2, e),
                            m(i) ? ff(i, t) : i && hf(i, t),
                            n(') => '),
                            (l || a) && (n('{'), r()),
                            s ? (l && n('return '), m(s) ? pf(s, t) : hf(s, t)) : a && hf(a, t),
                            (l || a) && (o(), n('}')),
                            c && (e.isNonScopedSlot && n(', undefined, true'), n(')')));
                    })(e, t);
                    break;
                case 19:
                    !(function (e, t) {
                        const { test: n, consequent: r, alternate: o, newline: i } = e,
                            { push: s, indent: a, deindent: l, newline: c } = t;
                        if (4 === n.type) {
                            const e = !Gu(n.content);
                            (e && s('('), mf(n, t), e && s(')'));
                        } else (s('('), hf(n, t), s(')'));
                        (i && a(),
                            t.indentLevel++,
                            i || s(' '),
                            s('? '),
                            hf(r, t),
                            t.indentLevel--,
                            i && c(),
                            i || s(' '),
                            s(': '));
                        const d = 19 === o.type;
                        (d || t.indentLevel++, hf(o, t), d || t.indentLevel--, i && l(!0));
                    })(e, t);
                    break;
                case 20:
                    !(function (e, t) {
                        const { push: n, helper: r, indent: o, deindent: i, newline: s } = t,
                            { needPauseTracking: a, needArraySpread: l } = e;
                        (l && n('[...('),
                            n(`_cache[${e.index}] || (`),
                            a && (o(), n(`${r(su)}(-1`), e.inVOnce && n(', true'), n('),'), s(), n('(')),
                            n(`_cache[${e.index}] = `),
                            hf(e.value, t),
                            a &&
                                (n(`).cacheIndex = ${e.index},`),
                                s(),
                                n(`${r(su)}(1),`),
                                s(),
                                n(`_cache[${e.index}]`),
                                i()),
                            n(')'),
                            l && n(')]'));
                    })(e, t);
                    break;
                case 21:
                    ff(e.body, t, !0, !1);
                    break;
                case 22:
                case 23:
                case 24:
                case 25:
                case 26:
                case 10:
                    break;
                default:
                    return (ep(!1, `unhandled codegen node type: ${e.type}`), e);
            }
    }
    function mf(e, t) {
        const { content: n, isStatic: r } = e;
        t.push(r ? JSON.stringify(n) : n, -3, e);
    }
    function gf(e, t) {
        for (let n = 0; n < e.children.length; n++) {
            const r = e.children[n];
            w(r) ? t.push(r, -3) : hf(r, t);
        }
    }
    function vf(e, t) {
        const { push: n } = t;
        8 === e.type
            ? (n('['), gf(e, t), n(']'))
            : e.isStatic
              ? n(Gu(e.content) ? e.content : JSON.stringify(e.content), -2, e)
              : n(`[${e.content}]`, -3, e);
    }
    const yf = new RegExp(
            '\\b' +
                'arguments,await,break,case,catch,class,const,continue,debugger,default,delete,do,else,export,extends,finally,for,function,if,import,let,new,return,super,switch,throw,try,var,void,while,with,yield'
                    .split(',')
                    .join('\\b|\\b') +
                '\\b'
        ),
        bf = /'(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`/g;
    function wf(e, t, n = !1, r = !1) {
        const o = e.content;
        if (o.trim())
            try {
                new Function(r ? ` ${o} ` : 'return ' + (n ? `(${o}) => {}` : `(${o})`));
            } catch (n) {
                let r = n.message;
                const i = o.replace(bf, '').match(yf);
                (i && (r = `avoid using JavaScript keyword as property name: "${i[0]}"`),
                    t.onError(zu(45, e.loc, void 0, r)));
            }
    }
    const Sf = (e, t) => {
        if (5 === e.type) e.content = xf(e.content, t);
        else if (1 === e.type) {
            const n = tp(e, 'memo');
            for (let r = 0; r < e.props.length; r++) {
                const o = e.props[r];
                if (7 === o.type && 'for' !== o.name) {
                    const e = o.exp,
                        r = o.arg;
                    (!e ||
                        4 !== e.type ||
                        ('on' === o.name && r) ||
                        (n && r && 4 === r.type && 'key' === r.content) ||
                        (o.exp = xf(e, t, 'slot' === o.name)),
                        r && 4 === r.type && !r.isStatic && (o.arg = xf(r, t)));
                }
            }
        }
    };
    function xf(e, t, n = !1, r = !1, o = Object.create(t.identifiers)) {
        return (wf(e, t, n, r), e);
    }
    const _f = lf(/^(?:if|else|else-if)$/, (e, t, n) =>
        (function (e, t, n, r) {
            if (!('else' === t.name || (t.exp && t.exp.content.trim()))) {
                const r = t.exp ? t.exp.loc : e.loc;
                (n.onError(zu(28, t.loc)), (t.exp = wu('true', !1, r)));
            }
            if ((t.exp && wf(t.exp, n), 'if' === t.name)) {
                const i = Tf(e, t),
                    s = { type: 9, loc: ((o = e.loc), Wp(o.start.offset, o.end.offset)), branches: [i] };
                if ((n.replaceNode(s), r)) return r(s, i, !0);
            } else {
                const o = n.parent.children,
                    i = [];
                let s = o.indexOf(e);
                for (; s-- >= -1; ) {
                    const a = o[s];
                    if (!a || !vp(a)) {
                        if (a && 9 === a.type) {
                            (('else-if' !== t.name && 'else' !== t.name) ||
                                void 0 !== a.branches[a.branches.length - 1].condition ||
                                n.onError(zu(30, e.loc)),
                                n.removeNode());
                            const o = Tf(e, t);
                            i.length &&
                                (!n.parent ||
                                    1 !== n.parent.type ||
                                    ('transition' !== n.parent.tag && 'Transition' !== n.parent.tag)) &&
                                (o.children = [...i, ...o.children]);
                            {
                                const e = o.userKey;
                                e &&
                                    a.branches.forEach(({ userKey: t }) => {
                                        Ef(t, e) && n.onError(zu(29, o.userKey.loc));
                                    });
                            }
                            a.branches.push(o);
                            const s = r && r(a, o, !1);
                            (af(o, n), s && s(), (n.currentNode = null));
                        } else n.onError(zu(30, e.loc));
                        break;
                    }
                    (n.removeNode(a), 3 === a.type && i.unshift(a));
                }
            }
            var o;
        })(e, t, n, (e, t, r) => {
            const o = n.parent.children;
            let i = o.indexOf(e),
                s = 0;
            for (; i-- >= 0; ) {
                const e = o[i];
                e && 9 === e.type && (s += e.branches.length);
            }
            return () => {
                if (r) e.codegenNode = Cf(t, s, n);
                else {
                    const r = (function (e) {
                        for (;;)
                            if (19 === e.type) {
                                if (19 !== e.alternate.type) return e;
                                e = e.alternate;
                            } else 20 === e.type && (e = e.value);
                    })(e.codegenNode);
                    r.alternate = Cf(t, s + e.branches.length - 1, n);
                }
            };
        })
    );
    function Tf(e, t) {
        const n = 3 === e.tagType;
        return {
            type: 10,
            loc: e.loc,
            condition: 'else' === t.name ? void 0 : t.exp,
            children: n && !tp(e, 'for') ? e.children : [e],
            userKey: np(e, 'key'),
            isTemplateIf: n
        };
    }
    function Cf(e, t, n) {
        return e.condition ? Tu(e.condition, kf(e, t, n), xu(n.helper(Dd), ['"v-if"', 'true'])) : kf(e, t, n);
    }
    function kf(e, t, n) {
        const { helper: r } = n,
            o = bu('key', wu(`${t}`, !1, mu, 2)),
            { children: i } = e,
            s = i[0];
        if (1 !== i.length || 1 !== s.type) {
            if (1 === i.length && 11 === s.type) {
                const e = s.codegenNode;
                return (up(e, o, n), e);
            }
            {
                let t = 64;
                return (
                    e.isTemplateIf || 1 !== i.filter(e => 3 !== e.type).length || (t |= 2048),
                    gu(n, r(Od), yu([o]), i, t, void 0, void 0, !0, !1, !1, e.loc)
                );
            }
        }
        {
            const e = s.codegenNode,
                t = 14 === (a = e).type && a.callee === pu ? a.arguments[1].returns : a;
            return (13 === t.type && Eu(t, n), up(t, o, n), e);
        }
        var a;
    }
    function Ef(e, t) {
        if (!e || e.type !== t.type) return !1;
        if (6 === e.type) {
            if (e.value.content !== t.value.content) return !1;
        } else {
            const n = e.exp,
                r = t.exp;
            if (n.type !== r.type) return !1;
            if (4 !== n.type || n.isStatic !== r.isStatic || n.content !== r.content) return !1;
        }
        return !0;
    }
    const Af = lf('for', (e, t, n) => {
        const { helper: r, removeHelper: o } = n;
        return (function (e, t, n, r) {
            if (!t.exp) return void n.onError(zu(31, t.loc));
            const o = t.forParseResult;
            if (!o) return void n.onError(zu(32, t.loc));
            Of(o, n);
            const { addIdentifiers: i, removeIdentifiers: s, scopes: a } = n,
                { source: l, value: c, key: d, index: u } = o,
                p = {
                    type: 11,
                    loc: t.loc,
                    source: l,
                    valueAlias: c,
                    keyAlias: d,
                    objectIndexAlias: u,
                    parseResult: o,
                    children: ap(e) ? e.children : [e]
                };
            (n.replaceNode(p), a.vFor++);
            const f = r && r(p);
            return () => {
                (a.vFor--, f && f());
            };
        })(e, t, n, t => {
            const i = xu(r(Gd), [t.source]),
                s = ap(e),
                a = tp(e, 'memo'),
                l = np(e, 'key', !1, !0);
            l && l.type;
            let c = l && (6 === l.type ? (l.value ? wu(l.value.content, !0) : void 0) : l.exp);
            const d = l && c ? bu('key', c) : null,
                u = 4 === t.source.type && t.source.constType > 0,
                p = u ? 64 : l ? 128 : 256;
            return (
                (t.codegenNode = gu(n, r(Od), void 0, i, p, void 0, void 0, !0, !u, !1, e.loc)),
                () => {
                    let l;
                    const { children: p } = t;
                    s &&
                        e.children.some(e => {
                            if (1 === e.type) {
                                const t = np(e, 'key');
                                if (t) return (n.onError(zu(33, t.loc)), !0);
                            }
                        });
                    const f = 1 !== p.length || 1 !== p[0].type,
                        h = lp(e) ? e : s && 1 === e.children.length && lp(e.children[0]) ? e.children[0] : null;
                    if (
                        (h
                            ? ((l = h.codegenNode), s && d && up(l, d, n))
                            : f
                              ? (l = gu(n, r(Od), d ? yu([d]) : void 0, e.children, 64, void 0, void 0, !0, void 0, !1))
                              : ((l = p[0].codegenNode),
                                s && d && up(l, d, n),
                                l.isBlock !== !u &&
                                    (l.isBlock
                                        ? (o(Ld), o(ku(n.inSSR, l.isComponent)))
                                        : o(Cu(n.inSSR, l.isComponent))),
                                (l.isBlock = !u),
                                l.isBlock ? (r(Ld), r(ku(n.inSSR, l.isComponent))) : r(Cu(n.inSSR, l.isComponent))),
                        a)
                    ) {
                        const e = _u(If(t.parseResult, [wu('_cached')]));
                        ((e.body = {
                            type: 21,
                            body: [
                                Su(['const _memo = (', a.exp, ')']),
                                Su([
                                    'if (_cached',
                                    ...(c ? [' && _cached.key === ', c] : []),
                                    ` && ${n.helperString(fu)}(_cached, _memo)) return _cached`
                                ]),
                                Su(['const _item = ', l]),
                                wu('_item.memo = _memo'),
                                wu('return _item')
                            ],
                            loc: mu
                        }),
                            i.arguments.push(e, wu('_cache'), wu(String(n.cached.length))),
                            n.cached.push(null));
                    } else i.arguments.push(_u(If(t.parseResult), l, !0));
                }
            );
        });
    });
    function Of(e, t) {
        e.finalized ||
            (wf(e.source, t),
            e.key && wf(e.key, t, !0),
            e.index && wf(e.index, t, !0),
            e.value && wf(e.value, t, !0),
            (e.finalized = !0));
    }
    function If({ value: e, key: t, index: n }, r = []) {
        return (function (e) {
            let t = e.length;
            for (; t-- && !e[t]; );
            return e.slice(0, t + 1).map((e, t) => e || wu('_'.repeat(t + 1), !1));
        })([e, t, n, ...r]);
    }
    const Mf = wu('undefined', !1),
        Pf = (e, t) => {
            if (1 === e.type && (1 === e.tagType || 3 === e.tagType)) {
                const n = tp(e, 'slot');
                if (n)
                    return (
                        n.exp,
                        t.scopes.vSlot++,
                        () => {
                            t.scopes.vSlot--;
                        }
                    );
            }
        },
        Nf = (e, t, n, r) => _u(e, n, !1, !0, n.length ? n[0].loc : r);
    function Lf(e, t, n = Nf) {
        t.helper(cu);
        const { children: r, loc: o } = e,
            i = [],
            s = [];
        let a = t.scopes.vSlot > 0 || t.scopes.vFor > 0;
        const l = tp(e, 'slot', !0);
        if (l) {
            const { arg: e, exp: t } = l;
            (e && !Uu(e) && (a = !0), i.push(bu(e || wu('default', !0), n(t, void 0, r, o))));
        }
        let c = !1,
            d = !1;
        const u = [],
            p = new Set();
        let f = 0;
        for (let e = 0; e < r.length; e++) {
            const o = r[e];
            let h;
            if (!ap(o) || !(h = tp(o, 'slot', !0))) {
                3 !== o.type && u.push(o);
                continue;
            }
            if (l) {
                t.onError(zu(37, h.loc));
                break;
            }
            c = !0;
            const { children: m, loc: g } = o,
                { arg: v = wu('default', !0), exp: y, loc: b } = h;
            let w;
            Uu(v) ? (w = v ? v.content : 'default') : (a = !0);
            const S = tp(o, 'for'),
                x = n(y, S, m, g);
            let _, T;
            if ((_ = tp(o, 'if'))) ((a = !0), s.push(Tu(_.exp, Rf(v, x, f++), Mf)));
            else if ((T = tp(o, /^else(?:-if)?$/, !0))) {
                let n,
                    o = e;
                for (; o-- && ((n = r[o]), vp(n)); );
                if (n && ap(n) && tp(n, /^(?:else-)?if$/)) {
                    let e = s[s.length - 1];
                    for (; 19 === e.alternate.type; ) e = e.alternate;
                    e.alternate = T.exp ? Tu(T.exp, Rf(v, x, f++), Mf) : Rf(v, x, f++);
                } else t.onError(zu(30, T.loc));
            } else if (S) {
                a = !0;
                const e = S.forParseResult;
                e
                    ? (Of(e, t), s.push(xu(t.helper(Gd), [e.source, _u(If(e), Rf(v, x), !0)])))
                    : t.onError(zu(32, S.loc));
            } else {
                if (w) {
                    if (p.has(w)) {
                        t.onError(zu(38, b));
                        continue;
                    }
                    (p.add(w), 'default' === w && (d = !0));
                }
                i.push(bu(v, x));
            }
        }
        if (!l) {
            const e = (e, r) => {
                const i = n(e, void 0, r, o);
                return (t.compatConfig && (i.isNonScopedSlot = !0), bu('default', i));
            };
            c
                ? u.length && !u.every(gp) && (d ? t.onError(zu(39, u[0].loc)) : i.push(e(void 0, u)))
                : i.push(e(void 0, r));
        }
        const h = a ? 2 : $f(e.children) ? 3 : 1;
        let m = yu(i.concat(bu('_', wu(h + ` /* ${W[h]} */`, !1))), o);
        return (s.length && (m = xu(t.helper(Kd), [m, vu(s)])), { slots: m, hasDynamicSlots: a });
    }
    function Rf(e, t, n) {
        const r = [bu('name', e), bu('fn', t)];
        return (null != n && r.push(bu('key', wu(String(n), !0))), yu(r));
    }
    function $f(e) {
        for (let t = 0; t < e.length; t++) {
            const n = e[t];
            switch (n.type) {
                case 1:
                    if (2 === n.tagType || $f(n.children)) return !0;
                    break;
                case 9:
                    if ($f(n.branches)) return !0;
                    break;
                case 10:
                case 11:
                    if ($f(n.children)) return !0;
            }
        }
        return !1;
    }
    const Bf = new WeakMap(),
        Ff = (e, t) =>
            function () {
                if (1 !== (e = t.currentNode).type || (0 !== e.tagType && 1 !== e.tagType)) return;
                const { tag: n, props: r } = e,
                    o = 1 === e.tagType;
                let i = o
                    ? (function (e, t, n = !1) {
                          let { tag: r } = e;
                          const o = zf(r),
                              i = np(e, 'is', !1, !0);
                          if (i)
                              if (o || Bu('COMPILER_IS_ON_ELEMENT', t)) {
                                  let e;
                                  if (
                                      (6 === i.type
                                          ? (e = i.value && wu(i.value.content, !0))
                                          : ((e = i.exp), e || (e = wu('is', !1, i.arg.loc))),
                                      e)
                                  )
                                      return xu(t.helper(Hd), [e]);
                              } else
                                  6 === i.type && i.value.content.startsWith('vue:') && (r = i.value.content.slice(4));
                          const s = qu(r) || t.isBuiltInComponent(r);
                          return s ? (n || t.helper(s), s) : (t.helper(zd), t.components.add(r), fp(r, 'component'));
                      })(e, t)
                    : `"${n}"`;
                const s = x(i) && i.callee === Hd;
                let a,
                    l,
                    c,
                    d,
                    u,
                    p = 0,
                    f = s || i === Id || i === Md || (!o && ('svg' === n || 'foreignObject' === n || 'math' === n));
                if (r.length > 0) {
                    const n = Df(e, t, void 0, o, s);
                    ((a = n.props), (p = n.patchFlag), (d = n.dynamicPropNames));
                    const r = n.directives;
                    ((u =
                        r && r.length
                            ? vu(
                                  r.map(e =>
                                      (function (e, t) {
                                          const n = [],
                                              r = Bf.get(e);
                                          r
                                              ? n.push(t.helperString(r))
                                              : (t.helper(Ud),
                                                t.directives.add(e.name),
                                                n.push(fp(e.name, 'directive')));
                                          const { loc: o } = e;
                                          if (
                                              (e.exp && n.push(e.exp),
                                              e.arg && (e.exp || n.push('void 0'), n.push(e.arg)),
                                              Object.keys(e.modifiers).length)
                                          ) {
                                              e.arg || (e.exp || n.push('void 0'), n.push('void 0'));
                                              const t = wu('true', !1, o);
                                              n.push(
                                                  yu(
                                                      e.modifiers.map(e => bu(e, t)),
                                                      o
                                                  )
                                              );
                                          }
                                          return vu(n, e.loc);
                                      })(e, t)
                                  )
                              )
                            : void 0),
                        n.shouldUseBlock && (f = !0));
                }
                if (e.children.length > 0)
                    if (
                        (i === Pd &&
                            ((f = !0),
                            (p |= 1024),
                            e.children.length > 1 &&
                                t.onError(
                                    zu(46, {
                                        start: e.children[0].loc.start,
                                        end: e.children[e.children.length - 1].loc.end,
                                        source: ''
                                    })
                                )),
                        o && i !== Id && i !== Pd)
                    ) {
                        const { slots: n, hasDynamicSlots: r } = Lf(e, t);
                        ((l = n), r && (p |= 1024));
                    } else if (1 === e.children.length && i !== Id) {
                        const n = e.children[0],
                            r = n.type,
                            o = 5 === r || 8 === r;
                        (o && 0 === ef(n, t) && (p |= 1), (l = o || 2 === r ? n : e.children));
                    } else l = e.children;
                (d &&
                    d.length &&
                    (c = (function (e) {
                        let t = '[';
                        for (let n = 0, r = e.length; n < r; n++)
                            ((t += JSON.stringify(e[n])), n < r - 1 && (t += ', '));
                        return t + ']';
                    })(d)),
                    (e.codegenNode = gu(t, i, a, l, 0 === p ? void 0 : p, c, u, !!f, !1, o, e.loc)));
            };
    function Df(e, t, n = e.props, r, o, i = !1) {
        const { tag: s, loc: a, children: l } = e;
        let d = [];
        const u = [],
            p = [],
            f = l.length > 0;
        let h = !1,
            m = 0,
            g = !1,
            v = !1,
            y = !1,
            b = !1,
            w = !1,
            x = !1;
        const _ = [],
            T = e => {
                (d.length && (u.push(yu(jf(d), a)), (d = [])), e && u.push(e));
            },
            C = () => {
                t.scopes.vFor > 0 && d.push(bu(wu('ref_for', !0), wu('true')));
            },
            k = ({ key: e, value: n }) => {
                if (Uu(e)) {
                    const i = e.content,
                        s = c(i);
                    if (
                        (!s ||
                            (r && !o) ||
                            'onclick' === i.toLowerCase() ||
                            'onUpdate:modelValue' === i ||
                            O(i) ||
                            (b = !0),
                        s && O(i) && (x = !0),
                        s && 14 === n.type && (n = n.arguments[0]),
                        20 === n.type || ((4 === n.type || 8 === n.type) && ef(n, t) > 0))
                    )
                        return;
                    ('ref' === i
                        ? (g = !0)
                        : 'class' === i
                          ? (v = !0)
                          : 'style' === i
                            ? (y = !0)
                            : 'key' === i || _.includes(i) || _.push(i),
                        !r || ('class' !== i && 'style' !== i) || _.includes(i) || _.push(i));
                } else w = !0;
            };
        for (let o = 0; o < n.length; o++) {
            const l = n[o];
            if (6 === l.type) {
                const { loc: e, name: n, nameLoc: r, value: o } = l;
                let i = !0;
                if (
                    ('ref' === n && ((g = !0), C()),
                    'is' === n && (zf(s) || (o && o.content.startsWith('vue:')) || Bu('COMPILER_IS_ON_ELEMENT', t)))
                )
                    continue;
                d.push(bu(wu(n, !0, r), wu(o ? o.content : '', i, o ? o.loc : e)));
            } else {
                const { name: n, arg: o, exp: g, loc: v, modifiers: y } = l,
                    b = 'bind' === n,
                    x = 'on' === n;
                if ('slot' === n) {
                    r || t.onError(zu(40, v));
                    continue;
                }
                if ('once' === n || 'memo' === n) continue;
                if ('is' === n || (b && rp(o, 'is') && (zf(s) || Bu('COMPILER_IS_ON_ELEMENT', t)))) continue;
                if (x && i) continue;
                if (
                    (((b && rp(o, 'key')) || (x && f && rp(o, 'vue:before-update'))) && (h = !0),
                    b && rp(o, 'ref') && C(),
                    !o && (b || x))
                ) {
                    if (((w = !0), g))
                        if (b) {
                            if (
                                (T(),
                                u.some(
                                    e =>
                                        15 !== e.type ||
                                        e.properties.some(
                                            ({ key: e }) =>
                                                4 !== e.type ||
                                                !e.isStatic ||
                                                ('class' !== e.content && 'style' !== e.content && !c(e.content))
                                        )
                                ) && Fu('COMPILER_V_BIND_OBJECT_ORDER', t, v),
                                Bu('COMPILER_V_BIND_OBJECT_ORDER', t))
                            ) {
                                u.unshift(g);
                                continue;
                            }
                            (C(), T(), u.push(g));
                        } else T({ type: 14, loc: v, callee: t.helper(nu), arguments: r ? [g] : [g, 'true'] });
                    else t.onError(zu(b ? 34 : 35, v));
                    continue;
                }
                b && y.some(e => 'prop' === e.content) && (m |= 32);
                const _ = t.directiveTransforms[n];
                if (_) {
                    const { props: n, needRuntime: r } = _(l, e, t);
                    (!i && n.forEach(k),
                        x && o && !Uu(o) ? T(yu(n, a)) : d.push(...n),
                        r && (p.push(l), S(r) && Bf.set(l, r)));
                } else I(n) || (p.push(l), f && (h = !0));
            }
        }
        let E;
        if (
            (u.length ? (T(), (E = u.length > 1 ? xu(t.helper(Jd), u, a) : u[0])) : d.length && (E = yu(jf(d), a)),
            w ? (m |= 16) : (v && !r && (m |= 2), y && !r && (m |= 4), _.length && (m |= 8), b && (m |= 32)),
            h || (0 !== m && 32 !== m) || !(g || x || p.length > 0) || (m |= 512),
            !t.inSSR && E)
        )
            switch (E.type) {
                case 15:
                    let e = -1,
                        n = -1,
                        r = !1;
                    for (let t = 0; t < E.properties.length; t++) {
                        const o = E.properties[t].key;
                        Uu(o)
                            ? 'class' === o.content
                                ? (e = t)
                                : 'style' === o.content && (n = t)
                            : o.isHandlerKey || (r = !0);
                    }
                    const o = E.properties[e],
                        i = E.properties[n];
                    r
                        ? (E = xu(t.helper(eu), [E]))
                        : (o && !Uu(o.value) && (o.value = xu(t.helper(Qd), [o.value])),
                          i &&
                              (y || (4 === i.value.type && '[' === i.value.content.trim()[0]) || 17 === i.value.type) &&
                              (i.value = xu(t.helper(Zd), [i.value])));
                    break;
                case 14:
                    break;
                default:
                    E = xu(t.helper(eu), [xu(t.helper(tu), [E])]);
            }
        return { props: E, directives: p, patchFlag: m, dynamicPropNames: _, shouldUseBlock: h };
    }
    function jf(e) {
        const t = new Map(),
            n = [];
        for (let r = 0; r < e.length; r++) {
            const o = e[r];
            if (8 === o.key.type || !o.key.isStatic) {
                n.push(o);
                continue;
            }
            const i = o.key.content,
                s = t.get(i);
            s ? ('style' === i || 'class' === i || c(i)) && Vf(s, o) : (t.set(i, o), n.push(o));
        }
        return n;
    }
    function Vf(e, t) {
        17 === e.value.type ? e.value.elements.push(t.value) : (e.value = vu([e.value, t.value], e.loc));
    }
    function zf(e) {
        return 'component' === e || 'Component' === e;
    }
    const Hf = (e, t) => {
            if (lp(e)) {
                const { children: n, loc: r } = e,
                    { slotName: o, slotProps: i } = (function (e, t) {
                        let n,
                            r = '"default"';
                        const o = [];
                        for (let t = 0; t < e.props.length; t++) {
                            const n = e.props[t];
                            if (6 === n.type)
                                n.value &&
                                    ('name' === n.name
                                        ? (r = JSON.stringify(n.value.content))
                                        : ((n.name = N(n.name)), o.push(n)));
                            else if ('bind' === n.name && rp(n.arg, 'name')) {
                                if (n.exp) r = n.exp;
                                else if (n.arg && 4 === n.arg.type) {
                                    const e = N(n.arg.content);
                                    r = n.exp = wu(e, !1, n.arg.loc);
                                }
                            } else
                                ('bind' === n.name && n.arg && Uu(n.arg) && (n.arg.content = N(n.arg.content)),
                                    o.push(n));
                        }
                        if (o.length > 0) {
                            const { props: r, directives: i } = Df(e, t, o, !1, !1);
                            ((n = r), i.length && t.onError(zu(36, i[0].loc)));
                        }
                        return { slotName: r, slotProps: n };
                    })(e, t),
                    s = [t.prefixIdentifiers ? '_ctx.$slots' : '$slots', o, '{}', 'undefined', 'true'];
                let a = 2;
                (i && ((s[2] = i), (a = 3)),
                    n.length && ((s[3] = _u([], n, !1, !1, r)), (a = 4)),
                    t.scopeId && !t.slotted && (a = 5),
                    s.splice(a),
                    (e.codegenNode = xu(t.helper(Yd), s, r)));
            }
        },
        Uf = (e, t, n, r) => {
            const { loc: o, modifiers: i, arg: s } = e;
            let a;
            if ((e.exp || i.length || n.onError(zu(35, o)), 4 === s.type))
                if (s.isStatic) {
                    let e = s.content;
                    (e.startsWith('vnode') && n.onError(zu(51, s.loc)),
                        e.startsWith('vue:') && (e = `vnode-${e.slice(4)}`),
                        (a = wu(
                            0 !== t.tagType || e.startsWith('vnode') || !/[A-Z]/.test(e) ? B(N(e)) : `on:${e}`,
                            !0,
                            s.loc
                        )));
                } else a = Su([`${n.helperString(iu)}(`, s, ')']);
            else ((a = s), a.children.unshift(`${n.helperString(iu)}(`), a.children.push(')'));
            let l = e.exp;
            l && !l.content.trim() && (l = void 0);
            let c = n.cacheHandlers && !l && !n.inVOnce;
            if (l) {
                const e = Qu(l),
                    t = !(e || (e => Zu.test(Ju(e)))(l)),
                    r = l.content.includes(';');
                (wf(l, n, !1, r),
                    (t || (c && e)) &&
                        (l = Su([`${t ? '$event' : '(...args)'} => ${r ? '{' : '('}`, l, r ? '}' : ')'])));
            }
            let d = { props: [bu(a, l || wu('() => {}', !1, o))] };
            return (
                r && (d = r(d)),
                c && (d.props[0].value = n.cache(d.props[0].value)),
                d.props.forEach(e => (e.key.isHandlerKey = !0)),
                d
            );
        },
        qf = (e, t, n) => {
            const { modifiers: r, loc: o } = e,
                i = e.arg;
            let { exp: s } = e;
            return (
                s && 4 === s.type && !s.content.trim() && (s = void 0),
                4 !== i.type
                    ? (i.children.unshift('('), i.children.push(') || ""'))
                    : i.isStatic || (i.content = i.content ? `${i.content} || ""` : '""'),
                r.some(e => 'camel' === e.content) &&
                    (4 === i.type
                        ? i.isStatic
                            ? (i.content = N(i.content))
                            : (i.content = `${n.helperString(ru)}(${i.content})`)
                        : (i.children.unshift(`${n.helperString(ru)}(`), i.children.push(')'))),
                n.inSSR ||
                    (r.some(e => 'prop' === e.content) && Wf(i, '.'), r.some(e => 'attr' === e.content) && Wf(i, '^')),
                { props: [bu(i, s)] }
            );
        },
        Wf = (e, t) => {
            4 === e.type
                ? e.isStatic
                    ? (e.content = t + e.content)
                    : (e.content = `\`${t}\${${e.content}}\``)
                : (e.children.unshift(`'${t}' + (`), e.children.push(')'));
        },
        Gf = (e, t) => {
            if (0 === e.type || 1 === e.type || 11 === e.type || 10 === e.type)
                return () => {
                    const n = e.children;
                    let r,
                        o = !1;
                    for (let e = 0; e < n.length; e++) {
                        const t = n[e];
                        if (op(t)) {
                            o = !0;
                            for (let o = e + 1; o < n.length; o++) {
                                const i = n[o];
                                if (!op(i)) {
                                    r = void 0;
                                    break;
                                }
                                (r || (r = n[e] = Su([t], t.loc)), r.children.push(' + ', i), n.splice(o, 1), o--);
                            }
                        }
                    }
                    if (
                        o &&
                        (1 !== n.length ||
                            (0 !== e.type &&
                                (1 !== e.type ||
                                    0 !== e.tagType ||
                                    e.props.find(e => 7 === e.type && !t.directiveTransforms[e.name]) ||
                                    'template' === e.tag)))
                    )
                        for (let e = 0; e < n.length; e++) {
                            const r = n[e];
                            if (op(r) || 8 === r.type) {
                                const o = [];
                                ((2 === r.type && ' ' === r.content) || o.push(r),
                                    t.ssr || 0 !== ef(r, t) || o.push(`1 /* ${q[1]} */`),
                                    (n[e] = { type: 12, content: r, loc: r.loc, codegenNode: xu(t.helper(jd), o) }));
                            }
                        }
                };
        },
        Yf = new WeakSet(),
        Kf = (e, t) => {
            if (1 === e.type && tp(e, 'once', !0)) {
                if (Yf.has(e) || t.inVOnce || t.inSSR) return;
                return (
                    Yf.add(e),
                    (t.inVOnce = !0),
                    t.helper(su),
                    () => {
                        t.inVOnce = !1;
                        const e = t.currentNode;
                        e.codegenNode && (e.codegenNode = t.cache(e.codegenNode, !0, !0));
                    }
                );
            }
        },
        Xf = (e, t, n) => {
            const { exp: r, arg: o } = e;
            if (!r) return (n.onError(zu(41, e.loc)), Jf());
            const i = r.loc.source.trim(),
                s = 4 === r.type ? r.content : i,
                a = n.bindingMetadata[i];
            if ('props' === a || 'props-aliased' === a) return (n.onError(zu(44, r.loc)), Jf());
            if (!s.trim() || !Qu(r)) return (n.onError(zu(42, r.loc)), Jf());
            const l = o || wu('modelValue', !0),
                c = o ? (Uu(o) ? `onUpdate:${N(o.content)}` : Su(['"onUpdate:" + ', o])) : 'onUpdate:modelValue';
            let d;
            d = Su([(n.isTS ? '($event: any)' : '$event') + ' => ((', r, ') = $event)']);
            const u = [bu(l, e.exp), bu(c, d)];
            if (e.modifiers.length && 1 === t.tagType) {
                const t = e.modifiers
                        .map(e => e.content)
                        .map(e => (Gu(e) ? e : JSON.stringify(e)) + ': true')
                        .join(', '),
                    n = o ? (Uu(o) ? `${o.content}Modifiers` : Su([o, ' + "Modifiers"'])) : 'modelModifiers';
                u.push(bu(n, wu(`{ ${t} }`, !1, e.loc, 2)));
            }
            return Jf(u);
        };
    function Jf(e = []) {
        return { props: e };
    }
    const Qf = /[\w).+\-_$\]]/,
        Zf = (e, t) => {
            Bu('COMPILER_FILTERS', t) &&
                (5 === e.type
                    ? eh(e.content, t)
                    : 1 === e.type &&
                      e.props.forEach(e => {
                          7 === e.type && 'for' !== e.name && e.exp && eh(e.exp, t);
                      }));
        };
    function eh(e, t) {
        if (4 === e.type) th(e, t);
        else
            for (let n = 0; n < e.children.length; n++) {
                const r = e.children[n];
                'object' == typeof r &&
                    (4 === r.type ? th(r, t) : 8 === r.type ? eh(e, t) : 5 === r.type && eh(r.content, t));
            }
    }
    function th(e, t) {
        const n = e.content;
        let r,
            o,
            i,
            s,
            a = !1,
            l = !1,
            c = !1,
            d = !1,
            u = 0,
            p = 0,
            f = 0,
            h = 0,
            m = [];
        for (i = 0; i < n.length; i++)
            if (((o = r), (r = n.charCodeAt(i)), a)) 39 === r && 92 !== o && (a = !1);
            else if (l) 34 === r && 92 !== o && (l = !1);
            else if (c) 96 === r && 92 !== o && (c = !1);
            else if (d) 47 === r && 92 !== o && (d = !1);
            else if (124 !== r || 124 === n.charCodeAt(i + 1) || 124 === n.charCodeAt(i - 1) || u || p || f) {
                switch (r) {
                    case 34:
                        l = !0;
                        break;
                    case 39:
                        a = !0;
                        break;
                    case 96:
                        c = !0;
                        break;
                    case 40:
                        f++;
                        break;
                    case 41:
                        f--;
                        break;
                    case 91:
                        p++;
                        break;
                    case 93:
                        p--;
                        break;
                    case 123:
                        u++;
                        break;
                    case 125:
                        u--;
                }
                if (47 === r) {
                    let e,
                        t = i - 1;
                    for (; t >= 0 && ((e = n.charAt(t)), ' ' === e); t--);
                    (e && Qf.test(e)) || (d = !0);
                }
            } else void 0 === s ? ((h = i + 1), (s = n.slice(0, i).trim())) : g();
        function g() {
            (m.push(n.slice(h, i).trim()), (h = i + 1));
        }
        if ((void 0 === s ? (s = n.slice(0, i).trim()) : 0 !== h && g(), m.length)) {
            for (Du('COMPILER_FILTERS', t, e.loc), i = 0; i < m.length; i++) s = nh(s, m[i], t);
            ((e.content = s), (e.ast = void 0));
        }
    }
    function nh(e, t, n) {
        n.helper(qd);
        const r = t.indexOf('(');
        if (r < 0) return (n.filters.add(t), `${fp(t, 'filter')}(${e})`);
        {
            const o = t.slice(0, r),
                i = t.slice(r + 1);
            return (n.filters.add(o), `${fp(o, 'filter')}(${e}${')' !== i ? ',' + i : i}`);
        }
    }
    const rh = new WeakSet(),
        oh = (e, t) => {
            if (1 === e.type) {
                const n = tp(e, 'memo');
                if (!n || rh.has(e) || t.inSSR) return;
                return (
                    rh.add(e),
                    () => {
                        const r = e.codegenNode || t.currentNode.codegenNode;
                        r &&
                            13 === r.type &&
                            (1 !== e.tagType && Eu(r, t),
                            (e.codegenNode = xu(t.helper(pu), [
                                n.exp,
                                _u(void 0, r),
                                '_cache',
                                String(t.cached.length)
                            ])),
                            t.cached.push(null));
                    }
                );
            }
        },
        ih = (e, t) => {
            if (1 === e.type)
                for (const n of e.props)
                    if (
                        7 === n.type &&
                        'bind' === n.name &&
                        (!n.exp || (4 === n.exp.type && !n.exp.content.trim())) &&
                        n.arg
                    ) {
                        const e = n.arg;
                        if (4 === e.type && e.isStatic) {
                            const t = N(e.content);
                            (Yu.test(t[0]) || '-' === t[0]) && (n.exp = wu(t, !1, e.loc));
                        } else (t.onError(zu(52, e.loc)), (n.exp = wu('', !0, e.loc)));
                    }
        };
    function sh(e, t = {}) {
        const n = t.onError || ju,
            r = 'module' === t.mode;
        (!0 === t.prefixIdentifiers ? n(zu(47)) : r && n(zu(48)),
            t.cacheHandlers && n(zu(49)),
            t.scopeId && !r && n(zu(50)));
        const o = u({}, t, { prefixIdentifiers: !1 }),
            i = w(e)
                ? (function (e, t) {
                      if (
                          (Mp.reset(),
                          (xp = null),
                          (_p = null),
                          (Tp = ''),
                          (Cp = -1),
                          (kp = -1),
                          (Ip.length = 0),
                          (Sp = e),
                          (bp = u({}, yp)),
                          t)
                      ) {
                          let e;
                          for (e in t) null != t[e] && (bp[e] = t[e]);
                      }
                      if (!bp.decodeEntities)
                          throw new Error('[@vue/compiler-core] decodeEntities option is required in browser builds.');
                      ((Mp.mode = 'html' === bp.parseMode ? 1 : 'sfc' === bp.parseMode ? 2 : 0),
                          (Mp.inXML = 1 === bp.ns || 2 === bp.ns));
                      const n = t && t.delimiters;
                      n && ((Mp.delimiterOpen = Nu(n[0])), (Mp.delimiterClose = Nu(n[1])));
                      const r = (wp = (function (e, t = '') {
                          return {
                              type: 0,
                              source: t,
                              children: [],
                              helpers: new Set(),
                              components: [],
                              directives: [],
                              hoists: [],
                              imports: [],
                              cached: [],
                              temps: 0,
                              codegenNode: void 0,
                              loc: mu
                          };
                      })(0, e));
                      return (Mp.parse(Sp), (r.loc = Wp(0, e.length)), (r.children = zp(r.children)), (wp = null), r);
                  })(e, o)
                : e,
            [s, a] = [[ih, Kf, _f, oh, Af, Zf, Sf, Hf, Ff, Pf, Gf], { on: Uf, bind: qf, model: Xf }];
        return (
            sf(
                i,
                u({}, o, {
                    nodeTransforms: [...s, ...(t.nodeTransforms || [])],
                    directiveTransforms: u({}, a, t.directiveTransforms || {})
                })
            ),
            (function (e, t = {}) {
                const n = (function (
                    e,
                    {
                        mode: t = 'function',
                        prefixIdentifiers: n = 'module' === t,
                        sourceMap: r = !1,
                        filename: o = 'template.vue.html',
                        scopeId: i = null,
                        optimizeImports: s = !1,
                        runtimeGlobalName: a = 'Vue',
                        runtimeModuleName: l = 'vue',
                        ssrRuntimeModuleName: c = 'vue/server-renderer',
                        ssr: d = !1,
                        isTS: u = !1,
                        inSSR: p = !1
                    }
                ) {
                    const f = {
                        mode: t,
                        prefixIdentifiers: n,
                        sourceMap: r,
                        filename: o,
                        scopeId: i,
                        optimizeImports: s,
                        runtimeGlobalName: a,
                        runtimeModuleName: l,
                        ssrRuntimeModuleName: c,
                        ssr: d,
                        isTS: u,
                        inSSR: p,
                        source: e.source,
                        code: '',
                        column: 1,
                        line: 1,
                        offset: 0,
                        indentLevel: 0,
                        pure: !1,
                        map: void 0,
                        helper: e => `_${hu[e]}`,
                        push(e, t = -2, n) {
                            f.code += e;
                        },
                        indent() {
                            h(++f.indentLevel);
                        },
                        deindent(e = !1) {
                            e ? --f.indentLevel : h(--f.indentLevel);
                        },
                        newline() {
                            h(f.indentLevel);
                        }
                    };
                    function h(e) {
                        f.push('\n' + '  '.repeat(e), 0);
                    }
                    return f;
                })(e, t);
                t.onContextCreated && t.onContextCreated(n);
                const {
                        mode: r,
                        push: o,
                        prefixIdentifiers: i,
                        indent: s,
                        deindent: a,
                        newline: l,
                        scopeId: c,
                        ssr: d
                    } = n,
                    u = Array.from(e.helpers),
                    p = u.length > 0,
                    f = !i && 'module' !== r;
                if (
                    ((function (e, t) {
                        const {
                                ssr: n,
                                prefixIdentifiers: r,
                                push: o,
                                newline: i,
                                runtimeModuleName: s,
                                runtimeGlobalName: a,
                                ssrRuntimeModuleName: l
                            } = t,
                            c = a,
                            d = Array.from(e.helpers);
                        (d.length > 0 &&
                            (o(`const _Vue = ${c}\n`, -1), e.hoists.length) &&
                            o(
                                `const { ${[Bd, Fd, Dd, jd, Vd]
                                    .filter(e => d.includes(e))
                                    .map(df)
                                    .join(', ')} } = _Vue\n`,
                                -1
                            ),
                            (function (e, t) {
                                if (!e.length) return;
                                t.pure = !0;
                                const { push: n, newline: r } = t;
                                r();
                                for (let o = 0; o < e.length; o++) {
                                    const i = e[o];
                                    i && (n(`const _hoisted_${o + 1} = `), hf(i, t), r());
                                }
                                t.pure = !1;
                            })(e.hoists, t),
                            i(),
                            o('return '));
                    })(e, n),
                    o(
                        `function ${d ? 'ssrRender' : 'render'}(${(d ? ['_ctx', '_push', '_parent', '_attrs'] : ['_ctx', '_cache']).join(', ')}) {`
                    ),
                    s(),
                    f && (o('with (_ctx) {'), s(), p && (o(`const { ${u.map(df).join(', ')} } = _Vue\n`, -1), l())),
                    e.components.length &&
                        (uf(e.components, 'component', n), (e.directives.length || e.temps > 0) && l()),
                    e.directives.length && (uf(e.directives, 'directive', n), e.temps > 0 && l()),
                    e.filters && e.filters.length && (l(), uf(e.filters, 'filter', n), l()),
                    e.temps > 0)
                ) {
                    o('let ');
                    for (let t = 0; t < e.temps; t++) o(`${t > 0 ? ', ' : ''}_temp${t}`);
                }
                return (
                    (e.components.length || e.directives.length || e.temps) && (o('\n', 0), l()),
                    d || o('return '),
                    e.codegenNode ? hf(e.codegenNode, n) : o('null'),
                    f && (a(), o('}')),
                    a(),
                    o('}'),
                    { ast: e, code: n.code, preamble: '', map: n.map ? n.map.toJSON() : void 0 }
                );
            })(i, o)
        );
    }
    const ah = Symbol('vModelRadio'),
        lh = Symbol('vModelCheckbox'),
        ch = Symbol('vModelText'),
        dh = Symbol('vModelSelect'),
        uh = Symbol('vModelDynamic'),
        ph = Symbol('vOnModifiersGuard'),
        fh = Symbol('vOnKeysGuard'),
        hh = Symbol('vShow'),
        mh = Symbol('Transition'),
        gh = Symbol('TransitionGroup');
    var vh;
    let yh;
    ((vh = {
        [ah]: 'vModelRadio',
        [lh]: 'vModelCheckbox',
        [ch]: 'vModelText',
        [dh]: 'vModelSelect',
        [uh]: 'vModelDynamic',
        [ph]: 'withModifiers',
        [fh]: 'withKeys',
        [hh]: 'vShow',
        [mh]: 'Transition',
        [gh]: 'TransitionGroup'
    }),
        Object.getOwnPropertySymbols(vh).forEach(e => {
            hu[e] = vh[e];
        }));
    const bh = {
            parseMode: 'html',
            isVoidTag: oe,
            isNativeTag: e => te(e) || ne(e) || re(e),
            isPreTag: e => 'pre' === e,
            isIgnoreNewlineTag: e => 'pre' === e || 'textarea' === e,
            decodeEntities: function (e, t = !1) {
                return (
                    yh || (yh = document.createElement('div')),
                    t
                        ? ((yh.innerHTML = `<div foo="${e.replace(/"/g, '&quot;')}">`),
                          yh.children[0].getAttribute('foo'))
                        : ((yh.innerHTML = e), yh.textContent)
                );
            },
            isBuiltInComponent: e =>
                'Transition' === e || 'transition' === e
                    ? mh
                    : 'TransitionGroup' === e || 'transition-group' === e
                      ? gh
                      : void 0,
            getNamespace(e, t, n) {
                let r = t ? t.ns : n;
                if (t && 2 === r)
                    if ('annotation-xml' === t.tag) {
                        if ('svg' === e) return 1;
                        t.props.some(
                            e =>
                                6 === e.type &&
                                'encoding' === e.name &&
                                null != e.value &&
                                ('text/html' === e.value.content || 'application/xhtml+xml' === e.value.content)
                        ) && (r = 0);
                    } else /^m(?:[ions]|text)$/.test(t.tag) && 'mglyph' !== e && 'malignmark' !== e && (r = 0);
                else t && 1 === r && (('foreignObject' !== t.tag && 'desc' !== t.tag && 'title' !== t.tag) || (r = 0));
                if (0 === r) {
                    if ('svg' === e) return 1;
                    if ('math' === e) return 2;
                }
                return r;
            }
        },
        wh = (e, t) => {
            const n = Q(e);
            return wu(JSON.stringify(n), !1, t, 3);
        };
    function Sh(e, t) {
        return zu(e, t, xh);
    }
    const xh = {
            53: 'v-html is missing expression.',
            54: 'v-html will override element children.',
            55: 'v-text is missing expression.',
            56: 'v-text will override element children.',
            57: 'v-model can only be used on <input>, <textarea> and <select> elements.',
            58: 'v-model argument is not supported on plain elements.',
            59: 'v-model cannot be used on file inputs since they are read-only. Use a v-on:change listener instead.',
            60: "Unnecessary value binding used alongside v-model. It will interfere with v-model's behavior.",
            61: 'v-show is missing expression.',
            62: '<Transition> expects exactly one child element or component.',
            63: 'Tags with side effect (<script> and <style>) are ignored in client component templates.'
        },
        _h = o('passive,once,capture'),
        Th = o('stop,prevent,self,ctrl,shift,alt,meta,exact,middle'),
        Ch = o('left,right'),
        kh = o('onkeyup,onkeydown,onkeypress'),
        Eh = (e, t) =>
            Uu(e) && 'onclick' === e.content.toLowerCase()
                ? wu(t, !0)
                : 4 !== e.type
                  ? Su(['(', e, `) === "onClick" ? "${t}" : (`, e, ')'])
                  : e;
    function Ah(e) {
        const t = (e.children = e.children.filter(e => !vp(e))),
            n = t[0];
        return 1 !== t.length || 11 === n.type || (9 === n.type && n.branches.some(Ah));
    }
    const Oh = (e, t) => {
            1 !== e.type ||
                0 !== e.tagType ||
                ('script' !== e.tag && 'style' !== e.tag) ||
                (t.onError(Sh(63, e.loc)), t.removeNode());
        },
        Ih = new Set(['h1', 'h2', 'h3', 'h4', 'h5', 'h6']),
        Mh = new Set([]),
        Ph = {
            head: new Set([
                'base',
                'basefront',
                'bgsound',
                'link',
                'meta',
                'title',
                'noscript',
                'noframes',
                'style',
                'script',
                'template'
            ]),
            optgroup: new Set(['option']),
            select: new Set(['optgroup', 'option', 'hr']),
            table: new Set(['caption', 'colgroup', 'tbody', 'tfoot', 'thead']),
            tr: new Set(['td', 'th']),
            colgroup: new Set(['col']),
            tbody: new Set(['tr']),
            thead: new Set(['tr']),
            tfoot: new Set(['tr']),
            script: Mh,
            iframe: Mh,
            option: Mh,
            textarea: Mh,
            style: Mh,
            title: Mh
        },
        Nh = {
            html: Mh,
            body: new Set(['html']),
            head: new Set(['html']),
            td: new Set(['tr']),
            colgroup: new Set(['table']),
            caption: new Set(['table']),
            tbody: new Set(['table']),
            tfoot: new Set(['table']),
            col: new Set(['colgroup']),
            th: new Set(['tr']),
            thead: new Set(['table']),
            tr: new Set(['tbody', 'thead', 'tfoot']),
            dd: new Set(['dl', 'div']),
            dt: new Set(['dl', 'div']),
            figcaption: new Set(['figure']),
            summary: new Set(['details']),
            area: new Set(['map'])
        },
        Lh = {
            p: new Set([
                'address',
                'article',
                'aside',
                'blockquote',
                'center',
                'details',
                'dialog',
                'dir',
                'div',
                'dl',
                'fieldset',
                'figure',
                'footer',
                'form',
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6',
                'header',
                'hgroup',
                'hr',
                'li',
                'main',
                'nav',
                'menu',
                'ol',
                'p',
                'pre',
                'section',
                'table',
                'ul'
            ]),
            svg: new Set([
                'b',
                'blockquote',
                'br',
                'code',
                'dd',
                'div',
                'dl',
                'dt',
                'em',
                'embed',
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6',
                'hr',
                'i',
                'img',
                'li',
                'menu',
                'meta',
                'ol',
                'p',
                'pre',
                'ruby',
                's',
                'small',
                'span',
                'strong',
                'sub',
                'sup',
                'table',
                'u',
                'ul',
                'var'
            ])
        },
        Rh = {
            a: new Set(['a']),
            button: new Set(['button']),
            dd: new Set(['dd', 'dt']),
            dt: new Set(['dd', 'dt']),
            form: new Set(['form']),
            li: new Set(['li']),
            h1: Ih,
            h2: Ih,
            h3: Ih,
            h4: Ih,
            h5: Ih,
            h6: Ih
        },
        $h = [
            e => {
                1 === e.type &&
                    e.props.forEach((t, n) => {
                        6 === t.type &&
                            'style' === t.name &&
                            t.value &&
                            (e.props[n] = {
                                type: 7,
                                name: 'bind',
                                arg: wu('style', !0, t.loc),
                                exp: wh(t.value.content, t.loc),
                                modifiers: [],
                                loc: t.loc
                            });
                    });
            },
            (e, t) => {
                if (1 === e.type && 1 === e.tagType && t.isBuiltInComponent(e.tag) === mh)
                    return () => {
                        if (!e.children.length) return;
                        Ah(e) &&
                            t.onError(
                                Sh(62, {
                                    start: e.children[0].loc.start,
                                    end: e.children[e.children.length - 1].loc.end,
                                    source: ''
                                })
                            );
                        const n = e.children[0];
                        if (1 === n.type)
                            for (const t of n.props)
                                7 === t.type &&
                                    'show' === t.name &&
                                    e.props.push({
                                        type: 6,
                                        name: 'persisted',
                                        nameLoc: e.loc,
                                        value: void 0,
                                        loc: e.loc
                                    });
                    };
            },
            (e, t) => {
                if (
                    1 === e.type &&
                    0 === e.tagType &&
                    t.parent &&
                    1 === t.parent.type &&
                    0 === t.parent.tagType &&
                    ((n = t.parent.tag),
                    (r = e.tag),
                    'template' !== n &&
                        (n in Ph
                            ? !Ph[n].has(r)
                            : r in Nh
                              ? !Nh[r].has(n)
                              : (n in Lh && Lh[n].has(r)) || (r in Rh && Rh[r].has(n))))
                ) {
                    const n = new SyntaxError(
                        `<${e.tag}> cannot be child of <${t.parent.tag}>, according to HTML specifications. This can cause hydration errors or potentially disrupt future functionality.`
                    );
                    ((n.loc = e.loc), t.onWarn(n));
                }
                var n, r;
            }
        ],
        Bh = {
            cloak: () => ({ props: [] }),
            html: (e, t, n) => {
                const { exp: r, loc: o } = e;
                return (
                    r || n.onError(Sh(53, o)),
                    t.children.length && (n.onError(Sh(54, o)), (t.children.length = 0)),
                    { props: [bu(wu('innerHTML', !0, o), r || wu('', !0))] }
                );
            },
            text: (e, t, n) => {
                const { exp: r, loc: o } = e;
                return (
                    r || n.onError(Sh(55, o)),
                    t.children.length && (n.onError(Sh(56, o)), (t.children.length = 0)),
                    {
                        props: [
                            bu(
                                wu('textContent', !0),
                                r ? (ef(r, n) > 0 ? r : xu(n.helperString(Xd), [r], o)) : wu('', !0)
                            )
                        ]
                    }
                );
            },
            model: (e, t, n) => {
                const r = Xf(e, t, n);
                if (!r.props.length || 1 === t.tagType) return r;
                function o() {
                    const e = tp(t, 'bind');
                    e && rp(e.arg, 'value') && n.onError(Sh(60, e.loc));
                }
                e.arg && n.onError(Sh(58, e.arg.loc));
                const { tag: i } = t,
                    s = n.isCustomElement(i);
                if ('input' === i || 'textarea' === i || 'select' === i || s) {
                    let a = ch,
                        l = !1;
                    if ('input' === i || s) {
                        const r = np(t, 'type');
                        if (r) {
                            if (7 === r.type) a = uh;
                            else if (r.value)
                                switch (r.value.content) {
                                    case 'radio':
                                        a = ah;
                                        break;
                                    case 'checkbox':
                                        a = lh;
                                        break;
                                    case 'file':
                                        ((l = !0), n.onError(Sh(59, e.loc)));
                                        break;
                                    default:
                                        o();
                                }
                        } else
                            !(function (e) {
                                return e.props.some(
                                    e =>
                                        !(
                                            7 !== e.type ||
                                            'bind' !== e.name ||
                                            (e.arg && 4 === e.arg.type && e.arg.isStatic)
                                        )
                                );
                            })(t)
                                ? o()
                                : (a = uh);
                    } else 'select' === i ? (a = dh) : o();
                    l || (r.needRuntime = n.helper(a));
                } else n.onError(Sh(57, e.loc));
                return ((r.props = r.props.filter(e => !(4 === e.key.type && 'modelValue' === e.key.content))), r);
            },
            on: (e, t, n) =>
                Uf(e, t, n, t => {
                    const { modifiers: r } = e;
                    if (!r.length) return t;
                    let { key: o, value: i } = t.props[0];
                    const {
                        keyModifiers: s,
                        nonKeyModifiers: a,
                        eventOptionModifiers: l
                    } = ((e, t, n, r) => {
                        const o = [],
                            i = [],
                            s = [];
                        for (let a = 0; a < t.length; a++) {
                            const l = t[a].content;
                            ('native' === l && Fu('COMPILER_V_ON_NATIVE', n, r)) || _h(l)
                                ? s.push(l)
                                : Ch(l)
                                  ? Uu(e)
                                      ? kh(e.content.toLowerCase())
                                          ? o.push(l)
                                          : i.push(l)
                                      : (o.push(l), i.push(l))
                                  : Th(l)
                                    ? i.push(l)
                                    : o.push(l);
                        }
                        return { keyModifiers: o, nonKeyModifiers: i, eventOptionModifiers: s };
                    })(o, r, n, e.loc);
                    if (
                        (a.includes('right') && (o = Eh(o, 'onContextmenu')),
                        a.includes('middle') && (o = Eh(o, 'onMouseup')),
                        a.length && (i = xu(n.helper(ph), [i, JSON.stringify(a)])),
                        !s.length ||
                            (Uu(o) && !kh(o.content.toLowerCase())) ||
                            (i = xu(n.helper(fh), [i, JSON.stringify(s)])),
                        l.length)
                    ) {
                        const e = l.map($).join('');
                        o = Uu(o) ? wu(`${o.content}${e}`, !0) : Su(['(', o, `) + "${e}"`]);
                    }
                    return { props: [bu(o, i)] };
                }),
            show: (e, t, n) => {
                const { exp: r, loc: o } = e;
                return (r || n.onError(Sh(61, o)), { props: [], needRuntime: n.helper(hh) });
            }
        };
    xl();
    const Fh = Object.create(null);
    cl(function (e, t) {
        if (!w(e)) {
            if (!e.nodeType) return (kl('invalid template option: ', e), a);
            e = e.innerHTML;
        }
        const n = (function (e, t) {
                return e + JSON.stringify(t, (e, t) => ('function' == typeof t ? t.toString() : t));
            })(e, t),
            o = Fh[n];
        if (o) return o;
        if ('#' === e[0]) {
            const t = document.querySelector(e);
            (t || kl(`Template element not found or is empty: ${e}`), (e = t ? t.innerHTML : ''));
        }
        const i = u({ hoistStatic: !0, onError: l, onWarn: e => l(e, !0) }, t);
        i.isCustomElement || 'undefined' == typeof customElements || (i.isCustomElement = e => !!customElements.get(e));
        const { code: s } = (function (e, t = {}) {
            return sh(
                e,
                u({}, bh, t, {
                    nodeTransforms: [Oh, ...$h, ...(t.nodeTransforms || [])],
                    directiveTransforms: u({}, Bh, t.directiveTransforms || {}),
                    transformHoist: null
                })
            );
        })(e, i);
        function l(t, n = !1) {
            const r = n ? t.message : `Template compilation error: ${t.message}`,
                o =
                    t.loc &&
                    (function (e, t = 0, n = e.length) {
                        if ((t = Math.max(0, Math.min(t, e.length))) > (n = Math.max(0, Math.min(n, e.length))))
                            return '';
                        let r = e.split(/(\r?\n)/);
                        const o = r.filter((e, t) => t % 2 == 1);
                        r = r.filter((e, t) => t % 2 == 0);
                        let i = 0;
                        const s = [];
                        for (let e = 0; e < r.length; e++)
                            if (((i += r[e].length + ((o[e] && o[e].length) || 0)), i >= t)) {
                                for (let a = e - 2; a <= e + 2 || n > i; a++) {
                                    if (a < 0 || a >= r.length) continue;
                                    const l = a + 1;
                                    s.push(`${l}${' '.repeat(Math.max(3 - String(l).length, 0))}|  ${r[a]}`);
                                    const c = r[a].length,
                                        d = (o[a] && o[a].length) || 0;
                                    if (a === e) {
                                        const e = t - (i - (c + d)),
                                            r = Math.max(1, n > i ? c - e : n - t);
                                        s.push('   |  ' + ' '.repeat(e) + '^'.repeat(r));
                                    } else if (a > e) {
                                        if (n > i) {
                                            const e = Math.max(Math.min(n - i, c), 1);
                                            s.push('   |  ' + '^'.repeat(e));
                                        }
                                        i += c + d;
                                    }
                                }
                                break;
                            }
                        return s.join('\n');
                    })(e, t.loc.start.offset, t.loc.end.offset);
            kl(o ? `${r}\n${o}` : r);
        }
        const c = new Function('Vue', s)(r);
        return ((c._rc = !0), (Fh[n] = c));
    });
    const Dh = to({
            name: 'BannerPage',
            props: {
                title: { type: String, required: !1, default: 'Train Hard. Play Smart.\nRise Together.' },
                description: {
                    type: String,
                    required: !1,
                    default: 'A badminton club for those who want to grow — on and off the court.'
                },
                backgroundImage: { type: String, required: !1, default: null },
                buttonText: { type: String, required: !1, default: 'Become a Member' },
                buttonUrl: { type: String, required: !1, default: '#' },
                satisfiedText: { type: String, required: !1, default: 'Satisfied by 1k Users' }
            },
            setup: function (e) {
                var t = {
                        position: 'relative',
                        minHeight: '50vh',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center',
                        backgroundRepeat: 'no-repeat',
                        display: 'flex',
                        alignItems: 'center',
                        backgroundColor: '#222',
                        padding: '4rem 5%',
                        boxSizing: 'border-box'
                    },
                    n = {
                        position: 'absolute',
                        inset: 0,
                        background:
                            'linear-gradient(90deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 40%, rgba(0,0,0,0) 70%)',
                        pointerEvents: 'none',
                        zIndex: 1
                    };
                e.backgroundImage && (t.backgroundImage = 'url('.concat(e.backgroundImage, ')'));
                var r = { position: 'relative', zIndex: 2, color: '#fff', width: '100%', height: '100%' },
                    o = {
                        fontSize: 'clamp(2.8rem, 5.5vw, 4.2rem)',
                        fontWeight: '700',
                        lineHeight: '1.2',
                        letterSpacing: '-0.02em',
                        marginBottom: '2.5rem',
                        maxWidth: '600px'
                    },
                    i = {
                        fontSize: 'clamp(0.95rem, 1.6vw, 1.15rem)',
                        lineHeight: '1.8',
                        maxWidth: '420px',
                        opacity: 0.92
                    },
                    s = {
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '0.75rem',
                        padding: '1.1rem 2.2rem',
                        fontSize: '1rem',
                        fontWeight: '600',
                        color: '#000',
                        backgroundColor: '#fff',
                        border: 'none',
                        borderRadius: '50px',
                        cursor: 'pointer',
                        textDecoration: 'none',
                        transition: 'all 0.3s ease',
                        boxShadow: '0 4px 14px rgba(0,0,0,0.15)'
                    },
                    a = {
                        fontSize: 'clamp(0.85rem, 1.2vw, 0.95rem)',
                        fontWeight: '400',
                        opacity: 0.85,
                        marginBottom: '1.5rem',
                        letterSpacing: '0.02em'
                    },
                    l = {
                        position: 'absolute',
                        left: '5%',
                        top: '50%',
                        transform: 'translateY(-50%)',
                        maxWidth: '600px'
                    },
                    c = {
                        position: 'absolute',
                        right: '8%',
                        top: '50%',
                        transform: 'translateY(-50%)',
                        maxWidth: '420px',
                        textAlign: 'right'
                    },
                    d = function (t) {
                        var n = (e.buttonText || '').toLowerCase();
                        if (
                            ['đặt sân', 'dat san', 'đặt sân ngay', 'dat san ngay', 'bắt đầu ngay', 'bat dau ngay'].some(
                                function (e) {
                                    return n.includes(e);
                                }
                            )
                        ) {
                            var r;
                            t.preventDefault();
                            var o =
                                null !== (r = window.App) && void 0 !== r && r.baseUrl
                                    ? ''.concat(window.App.baseUrl, '/san-gia')
                                    : '/san-gia';
                            window.location.href = o;
                        }
                    };
                return function () {
                    return La('section', { class: 'banner-page-shortcode', style: t }, [
                        La('div', { style: n }, null),
                        La('div', { style: r }, [
                            La('div', { style: l }, [
                                e.satisfiedText && La('p', { style: a }, [e.satisfiedText]),
                                e.title &&
                                    La('h1', { style: o }, [
                                        e.title.split('\n').map(function (t, n) {
                                            return La('span', { key: n }, [
                                                t,
                                                n < e.title.split('\n').length - 1 && La('br', null, null)
                                            ]);
                                        })
                                    ]),
                                e.buttonText &&
                                    e.buttonUrl &&
                                    La('a', { href: e.buttonUrl, onClick: d, style: s }, [
                                        La('span', null, [e.buttonText]),
                                        La(
                                            'svg',
                                            {
                                                width: '18',
                                                height: '18',
                                                viewBox: '0 0 24 24',
                                                fill: 'none',
                                                xmlns: 'http://www.w3.org/2000/svg',
                                                stroke: 'currentColor',
                                                'stroke-width': '2.5',
                                                'stroke-linecap': 'round',
                                                'stroke-linejoin': 'round'
                                            },
                                            [La('path', { d: 'M5 12H19M19 12L13 6M19 12L13 18' }, null)]
                                        )
                                    ])
                            ]),
                            La('div', { style: c }, [e.description && La('p', { style: i }, [e.description])])
                        ])
                    ]);
                };
            }
        }),
        jh = to({
            name: 'BannerForYard',
              props: {
                  title: String,
                  title_color: String,
                  titleColor: String,
                  description: String,
                  text_align: String,
                  textAlign: String,
                  background_image: String,
                  backgroundImage: String,
                  button_text: String,
                  buttonText: String,
                  button_url: String,
                  buttonUrl: String,
                  button_bg_color: String,
                  buttonBgColor: String,
                  button_text_color: String,
                  buttonTextColor: String,
                  overlay_color: String,
                  overlayColor: String
              },
            setup: function (e) {
                  var t = e.backgroundImage || e.background_image || '',
                      n = !!t,
                      r = e.overlayColor || e.overlay_color || (n ? 'rgba(0,0,0,.35)' : 'transparent'),
                      o = e.titleColor || e.title_color || (n ? '#ffffff' : '#111111'),
                      i = n ? '#ffffff' : '#444444',
                      s = e.buttonText || e.button_text || '',
                      a = e.buttonUrl || e.button_url || '/dat-san',
                      l = e.buttonBgColor || e.button_bg_color || '#065e45',
                      c = e.buttonTextColor || e.button_text_color || '#ffffff',
                      u = (e.textAlign || e.text_align || 'center').toLowerCase(),
                      f = 'left' === u || 'right' === u || 'center' === u ? u : 'center',
                      p = 'left' === f ? 'flex-start' : 'right' === f ? 'flex-end' : 'center',
                      m = 'center' === f ? '16px auto 0' : 'right' === f ? '16px 0 0 auto' : '16px auto 0 0',
                      d = function (e) {
                        var t,
                            n = e.currentTarget.getAttribute('href') || '';
                        if (!n || '#' === n || n.startsWith('javascript:')) {
                            e.preventDefault();
                            var r =
                                window.BOOKING_URL ||
                                (null === (t = window.App) || void 0 === t ? void 0 : t.bookingUrl) ||
                                a ||
                                'http://kltn-quan-ly-san-cau-long.test/san-gia';
                            window.location.assign(r);
                        }
                    };
                return function () {
                    return La(
                        'section',
                        { class: 'banner-for-yard', style: { backgroundImage: t ? "url('".concat(t, "')") : void 0 } },
                        [
                              La('div', { class: 'banner-for-yard__overlay', style: { background: r } }, null),
                              La('div', { class: 'banner-for-yard__inner container', style: { justifyContent: p } }, [
                                  La('div', { style: { textAlign: f, width: '100%' } }, [
                                    e.title &&
                                        La(
                                            'h2',
                                            {
                                                class: 'banner-for-yard__title',
                                                  style: { color: o, fontSize: '48px', textAlign: f },
                                                  innerHTML: e.title
                                              },
                                              null
                                          ),
                                    e.description &&
                                        La(
                                          'p',
                                          {
                                              class: 'banner-for-yard__desc',
                                                  style: { color: i, fontSize: '20px', textAlign: f, margin: m },
                                                  innerHTML: e.description
                                              },
                                              null
                                          ),
                                    s &&
                                        La('div', { class: 'banner-for-yard__btn' }, [
                                            La(
                                                'a',
                                                {
                                                    href: a,
                                                    onClick: d,
                                                    class: 'btn',
                                                    style: { backgroundColor: l, color: c }
                                                },
                                                [s]
                                            )
                                        ])
                                ])
                            ])
                        ]
                    );
                };
            }
        }),
        Vh = to({
            name: 'CourtPricing',
            props: {
                title: { type: String, required: !0 },
                subtitle: { type: String, required: !0 },
                cards: { type: Array, required: !0 },
                viewAllText: { type: String, required: !0 },
                viewAllUrl: { type: String, required: !0 },
                titleColor: { type: String, default: '#000000' },
                subtitleColor: { type: String, default: '#666666' },
                viewAllColor: { type: String, default: '#0E6B5C' }
            },
            setup: function (e) {
                return function () {
                    return La(
                        'section',
                        {
                            style: {
                                backgroundColor: '#F8F7F4',
                                padding: '80px 0',
                                textAlign: 'center',
                                fontFamily: "'Be Vietnam Pro', sans-serif"
                            }
                        },
                        [
                            La('div', { class: 'container' }, [
                                La(
                                    'h2',
                                    {
                                        style: {
                                            fontSize: '2.5rem',
                                            fontWeight: 'bold',
                                            color: e.titleColor,
                                            marginBottom: '1rem'
                                        }
                                    },
                                    [e.title]
                                ),
                                e.subtitle &&
                                    La(
                                        'p',
                                        { style: { fontSize: '1.1rem', color: e.subtitleColor, marginBottom: '3rem' } },
                                        [e.subtitle]
                                    ),
                                La(
                                    'div',
                                    {
                                        class: 'cards-wrapper',
                                        style: {
                                            display: 'grid',
                                            gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))',
                                            gap: '2rem',
                                            maxWidth: '1200px',
                                            margin: '0 auto'
                                        }
                                    },
                                    [
                                        e.cards.map(function (e, t) {
                                            var n = e.card_bg_color || '#0E6B5C',
                                                r =
                                                    e.card_text_color && e.card_text_color.trim() !== n.trim()
                                                        ? e.card_text_color
                                                        : '#FFFFFF',
                                                o = [
                                                    'đặt sân',
                                                    'dat san',
                                                    'đặt sân ngay',
                                                    'dat san ngay',
                                                    'bắt đầu ngay',
                                                    'bat dau ngay'
                                                ].some(function (t) {
                                                    return (e.button_text || '').toLowerCase().includes(t);
                                                })
                                                    ? '/san-gia'
                                                    : e.button_url || '#';
                                            return La(
                                                'div',
                                                {
                                                    key: t,
                                                    class: 'pricing-card court-pricing-item',
                                                    style: {
                                                        backgroundColor: '#fff',
                                                        borderRadius: '15px',
                                                        overflow: 'hidden',
                                                        display: 'flex',
                                                        flexDirection: 'column',
                                                        textAlign: 'left'
                                                    }
                                                },
                                                [
                                                    La(
                                                        'div',
                                                        {
                                                            class: 'card-header',
                                                            style: {
                                                                backgroundColor: n,
                                                                color: r,
                                                                padding: '1.5rem 2rem',
                                                                position: 'relative'
                                                            }
                                                        },
                                                        [
                                                            La(
                                                                'div',
                                                                {
                                                                    style: {
                                                                        display: 'flex',
                                                                        justifyContent: 'space-between',
                                                                        alignItems: 'center',
                                                                        marginBottom: '1rem'
                                                                    }
                                                                },
                                                                [
                                                                    La(
                                                                        'h3',
                                                                        {
                                                                            style: {
                                                                                fontSize: '1.2rem',
                                                                                margin: 0,
                                                                                fontWeight: 600
                                                                            }
                                                                        },
                                                                        [e.title]
                                                                    ),
                                                                    e.tag &&
                                                                        La(
                                                                            'span',
                                                                            {
                                                                                class: 'tag',
                                                                                style: {
                                                                                    backgroundColor:
                                                                                        e.tag_bg_color ||
                                                                                        'rgba(255, 255, 255, 0.2)',
                                                                                    color: e.tag_text_color || '#fff',
                                                                                    padding: '4px 10px',
                                                                                    borderRadius: '12px',
                                                                                    fontSize: '0.75rem',
                                                                                    fontWeight: 500
                                                                                }
                                                                            },
                                                                            [e.tag]
                                                                        )
                                                                ]
                                                            ),
                                                            La(
                                                                'div',
                                                                {
                                                                    class: 'price',
                                                                    style: {
                                                                        fontSize: '2.8rem',
                                                                        fontWeight: 'bold',
                                                                        lineHeight: 1
                                                                    }
                                                                },
                                                                [
                                                                    e.price,
                                                                    La(
                                                                        'span',
                                                                        {
                                                                            style: {
                                                                                fontSize: '1rem',
                                                                                fontWeight: 'normal',
                                                                                marginLeft: '5px',
                                                                                textTransform: 'lowercase'
                                                                            }
                                                                        },
                                                                        [e.unit]
                                                                    )
                                                                ]
                                                            )
                                                        ]
                                                    ),
                                                    La(
                                                        'div',
                                                        { class: 'card-body', style: { padding: '2rem', flexGrow: 1 } },
                                                        [
                                                            La(
                                                                'ul',
                                                                { style: { listStyle: 'none', padding: 0, margin: 0 } },
                                                                [
                                                                    e.features.map(function (e, t) {
                                                                        return La(
                                                                            'li',
                                                                            {
                                                                                key: t,
                                                                                style: {
                                                                                    marginBottom: '1rem',
                                                                                    display: 'flex',
                                                                                    alignItems: 'center',
                                                                                    color: '#333'
                                                                                }
                                                                            },
                                                                            [
                                                                                La(
                                                                                    'span',
                                                                                    {
                                                                                        style: {
                                                                                            color: '#0E6B5C',
                                                                                            marginRight: '10px',
                                                                                            fontWeight: 'bold',
                                                                                            fontSize: '1.2rem',
                                                                                            lineHeight: 1
                                                                                        }
                                                                                    },
                                                                                    [Fa('•')]
                                                                                ),
                                                                                e
                                                                            ]
                                                                        );
                                                                    })
                                                                ]
                                                            )
                                                        ]
                                                    ),
                                                    La(
                                                        'div',
                                                        {
                                                            class: 'card-footer',
                                                            style: { padding: '0 2rem 2rem 2rem' }
                                                        },
                                                        [
                                                            La(
                                                                'a',
                                                                {
                                                                    href: o,
                                                                    onClick: function (t) {
                                                                        return (function (e, t, n) {
                                                                            var r = (n || '').trim().toLowerCase();
                                                                            if (
                                                                                [
                                                                                    'đặt sân',
                                                                                    'dat san',
                                                                                    'bắt đầu ngay',
                                                                                    'bat dau ngay'
                                                                                ].some(function (e) {
                                                                                    return r.includes(e);
                                                                                })
                                                                            ) {
                                                                                var o;
                                                                                e.preventDefault();
                                                                                var i =
                                                                                    window.BOOKING_URL ||
                                                                                    (null === (o = window.App) ||
                                                                                    void 0 === o
                                                                                        ? void 0
                                                                                        : o.bookingUrl) ||
                                                                                    'http://kltn-quan-ly-san-cau-long.test/san-gia';
                                                                                window.location.assign(i);
                                                                            } else
                                                                                t
                                                                                    ? (window.location.href = t)
                                                                                    : e.preventDefault();
                                                                        })(t, o, e.button_text);
                                                                    },
                                                                    style: {
                                                                        display: 'block',
                                                                        width: '100%',
                                                                        padding: '1rem',
                                                                        backgroundColor: e.button_bg_color || '#0E6B5C',
                                                                        color: e.button_text_color || '#fff',
                                                                        textAlign: 'center',
                                                                        textDecoration: 'none',
                                                                        borderRadius: '8px',
                                                                        fontWeight: 'bold',
                                                                        transition: 'opacity 0.3s'
                                                                    }
                                                                },
                                                                [e.button_text]
                                                            )
                                                        ]
                                                    )
                                                ]
                                            );
                                        })
                                    ]
                                ),
                                e.viewAllText &&
                                    e.viewAllUrl &&
                                    La(
                                        'a',
                                        {
                                            href: e.viewAllUrl,
                                            style: {
                                                display: 'inline-block',
                                                marginTop: '3rem',
                                                color: e.viewAllColor,
                                                textDecoration: 'none',
                                                fontWeight: 'bold'
                                            }
                                        },
                                        [e.viewAllText, Fa(' →')]
                                    )
                            ])
                        ]
                    );
                };
            }
        }),
        zh = to({
            name: 'WhyChoose',
            props: {
                title: { type: String, required: !0 },
                subtitle: { type: String, required: !1, default: '' },
                items: { type: Array, required: !0 },
                titleColor: { type: String, default: '#153E35' },
                subtitleColor: { type: String, default: '#6b7280' }
            },
            setup: function (e) {
                return function () {
                    return La(
                        'section',
                        {
                            class: 'why-choose-section',
                            style: {
                                backgroundColor: '#F3F7F5',
                                padding: '80px 0',
                                textAlign: 'center',
                                fontFamily: "'Baloo 2', sans-serif"
                            }
                        },
                        [
                            La('div', { class: 'container' }, [
                                La(
                                    'h2',
                                    {
                                        style: {
                                            fontSize: '40px',
                                            fontWeight: 800,
                                            color: e.titleColor,
                                            marginTop: 0,
                                            marginBottom: '0.5rem'
                                        }
                                    },
                                    [e.title]
                                ),
                                e.subtitle &&
                                    La('p', { style: { color: e.subtitleColor, marginBottom: '20px' } }, [e.subtitle]),
                                La(
                                    'div',
                                    {
                                        class: 'why-grid',
                                        style: {
                                            display: 'grid',
                                            gap: '2rem',
                                            maxWidth: '1200px',
                                            margin: '0 auto',
                                            gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))'
                                        }
                                    },
                                    [
                                        e.items.map(function (e, t) {
                                            return La('div', { key: t, class: 'why-choose-item' }, [
                                                La('h3', { style: { color: e.titleColor || void 0 } }, [e.title]),
                                                La('p', { style: { color: e.descColor || void 0 } }, [e.desc])
                                            ]);
                                        })
                                    ]
                                )
                            ])
                        ]
                    );
                };
            }
        });
    function Hh(e) {
        return null !== e && 'object' == typeof e && 'constructor' in e && e.constructor === Object;
    }
    function Uh(e = {}, t = {}) {
        const n = ['__proto__', 'constructor', 'prototype'];
        Object.keys(t)
            .filter(e => n.indexOf(e) < 0)
            .forEach(n => {
                void 0 === e[n]
                    ? (e[n] = t[n])
                    : Hh(t[n]) && Hh(e[n]) && Object.keys(t[n]).length > 0 && Uh(e[n], t[n]);
            });
    }
    const qh = {
        body: {},
        addEventListener() {},
        removeEventListener() {},
        activeElement: { blur() {}, nodeName: '' },
        querySelector: () => null,
        querySelectorAll: () => [],
        getElementById: () => null,
        createEvent: () => ({ initEvent() {} }),
        createElement: () => ({
            children: [],
            childNodes: [],
            style: {},
            setAttribute() {},
            getElementsByTagName: () => []
        }),
        createElementNS: () => ({}),
        importNode: () => null,
        location: { hash: '', host: '', hostname: '', href: '', origin: '', pathname: '', protocol: '', search: '' }
    };
    function Wh() {
        const e = 'undefined' != typeof document ? document : {};
        return (Uh(e, qh), e);
    }
    const Gh = {
        document: qh,
        navigator: { userAgent: '' },
        location: { hash: '', host: '', hostname: '', href: '', origin: '', pathname: '', protocol: '', search: '' },
        history: { replaceState() {}, pushState() {}, go() {}, back() {} },
        CustomEvent: function () {
            return this;
        },
        addEventListener() {},
        removeEventListener() {},
        getComputedStyle: () => ({ getPropertyValue: () => '' }),
        Image() {},
        Date() {},
        screen: {},
        setTimeout() {},
        clearTimeout() {},
        matchMedia: () => ({}),
        requestAnimationFrame: e => ('undefined' == typeof setTimeout ? (e(), null) : setTimeout(e, 0)),
        cancelAnimationFrame(e) {
            'undefined' != typeof setTimeout && clearTimeout(e);
        }
    };
    function Yh() {
        const e = 'undefined' != typeof window ? window : {};
        return (Uh(e, Gh), e);
    }
    function Kh(e, t = 0) {
        return setTimeout(e, t);
    }
    function Xh() {
        return Date.now();
    }
    function Jh(e) {
        return (
            'object' == typeof e &&
            null !== e &&
            e.constructor &&
            'Object' === Object.prototype.toString.call(e).slice(8, -1)
        );
    }
    function Qh(e) {
        return 'undefined' != typeof window && void 0 !== window.HTMLElement
            ? e instanceof HTMLElement
            : e && (1 === e.nodeType || 11 === e.nodeType);
    }
    function Zh(...e) {
        const t = Object(e[0]),
            n = ['__proto__', 'constructor', 'prototype'];
        for (let r = 1; r < e.length; r += 1) {
            const o = e[r];
            if (null != o && !Qh(o)) {
                const e = Object.keys(Object(o)).filter(e => n.indexOf(e) < 0);
                for (let n = 0, r = e.length; n < r; n += 1) {
                    const r = e[n],
                        i = Object.getOwnPropertyDescriptor(o, r);
                    void 0 !== i &&
                        i.enumerable &&
                        (Jh(t[r]) && Jh(o[r])
                            ? o[r].__swiper__
                                ? (t[r] = o[r])
                                : Zh(t[r], o[r])
                            : !Jh(t[r]) && Jh(o[r])
                              ? ((t[r] = {}), o[r].__swiper__ ? (t[r] = o[r]) : Zh(t[r], o[r]))
                              : (t[r] = o[r]));
                }
            }
        }
        return t;
    }
    function em(e, t, n) {
        e.style.setProperty(t, n);
    }
    function tm({ swiper: e, targetPosition: t, side: n }) {
        const r = Yh(),
            o = -e.translate;
        let i,
            s = null;
        const a = e.params.speed;
        ((e.wrapperEl.style.scrollSnapType = 'none'), r.cancelAnimationFrame(e.cssModeFrameID));
        const l = t > o ? 'next' : 'prev',
            c = (e, t) => ('next' === l && e >= t) || ('prev' === l && e <= t),
            d = () => {
                ((i = new Date().getTime()), null === s && (s = i));
                const l = Math.max(Math.min((i - s) / a, 1), 0),
                    u = 0.5 - Math.cos(l * Math.PI) / 2;
                let p = o + u * (t - o);
                if ((c(p, t) && (p = t), e.wrapperEl.scrollTo({ [n]: p }), c(p, t)))
                    return (
                        (e.wrapperEl.style.overflow = 'hidden'),
                        (e.wrapperEl.style.scrollSnapType = ''),
                        setTimeout(() => {
                            ((e.wrapperEl.style.overflow = ''), e.wrapperEl.scrollTo({ [n]: p }));
                        }),
                        void r.cancelAnimationFrame(e.cssModeFrameID)
                    );
                e.cssModeFrameID = r.requestAnimationFrame(d);
            };
        d();
    }
    function nm(e, t = '') {
        const n = Yh(),
            r = [...e.children];
        return (
            n.HTMLSlotElement && e instanceof HTMLSlotElement && r.push(...e.assignedElements()),
            t ? r.filter(e => e.matches(t)) : r
        );
    }
    function rm(e) {
        try {
            return void console.warn(e);
        } catch (e) {}
    }
    function om(e, t = []) {
        const n = document.createElement(e);
        return (
            n.classList.add(
                ...(Array.isArray(t)
                    ? t
                    : (function (e = '') {
                          return e
                              .trim()
                              .split(' ')
                              .filter(e => !!e.trim());
                      })(t))
            ),
            n
        );
    }
    function im(e, t) {
        return Yh().getComputedStyle(e, null).getPropertyValue(t);
    }
    function sm(e) {
        let t,
            n = e;
        if (n) {
            for (t = 0; null !== (n = n.previousSibling); ) 1 === n.nodeType && (t += 1);
            return t;
        }
    }
    function am(e, t, n) {
        const r = Yh();
        return n
            ? e['width' === t ? 'offsetWidth' : 'offsetHeight'] +
                  parseFloat(
                      r.getComputedStyle(e, null).getPropertyValue('width' === t ? 'margin-right' : 'margin-top')
                  ) +
                  parseFloat(
                      r.getComputedStyle(e, null).getPropertyValue('width' === t ? 'margin-left' : 'margin-bottom')
                  )
            : e.offsetWidth;
    }
    function lm(e, t = '') {
        'undefined' != typeof trustedTypes
            ? (e.innerHTML = trustedTypes.createPolicy('html', { createHTML: e => e }).createHTML(t))
            : (e.innerHTML = t);
    }
    let cm, dm, um;
    function pm() {
        return (
            cm ||
                (cm = (function () {
                    const e = Yh(),
                        t = Wh();
                    return {
                        smoothScroll:
                            t.documentElement && t.documentElement.style && 'scrollBehavior' in t.documentElement.style,
                        touch: !!('ontouchstart' in e || (e.DocumentTouch && t instanceof e.DocumentTouch))
                    };
                })()),
            cm
        );
    }
    function fm(e = {}) {
        return (
            dm ||
                (dm = (function ({ userAgent: e } = {}) {
                    const t = pm(),
                        n = Yh(),
                        r = n.navigator.platform,
                        o = e || n.navigator.userAgent,
                        i = { ios: !1, android: !1 },
                        s = n.screen.width,
                        a = n.screen.height,
                        l = o.match(/(Android);?[\s\/]+([\d.]+)?/);
                    let c = o.match(/(iPad)(?!\1).*OS\s([\d_]+)/);
                    const d = o.match(/(iPod)(.*OS\s([\d_]+))?/),
                        u = !c && o.match(/(iPhone\sOS|iOS)\s([\d_]+)/),
                        p = 'Win32' === r;
                    let f = 'MacIntel' === r;
                    return (
                        !c &&
                            f &&
                            t.touch &&
                            [
                                '1024x1366',
                                '1366x1024',
                                '834x1194',
                                '1194x834',
                                '834x1112',
                                '1112x834',
                                '768x1024',
                                '1024x768',
                                '820x1180',
                                '1180x820',
                                '810x1080',
                                '1080x810'
                            ].indexOf(`${s}x${a}`) >= 0 &&
                            ((c = o.match(/(Version)\/([\d.]+)/)), c || (c = [0, 1, '13_0_0']), (f = !1)),
                        l && !p && ((i.os = 'android'), (i.android = !0)),
                        (c || u || d) && ((i.os = 'ios'), (i.ios = !0)),
                        i
                    );
                })(e)),
            dm
        );
    }
    function hm() {
        return (
            um ||
                (um = (function () {
                    const e = Yh(),
                        t = fm();
                    let n = !1;
                    function r() {
                        const t = e.navigator.userAgent.toLowerCase();
                        return t.indexOf('safari') >= 0 && t.indexOf('chrome') < 0 && t.indexOf('android') < 0;
                    }
                    if (r()) {
                        const t = String(e.navigator.userAgent);
                        if (t.includes('Version/')) {
                            const [e, r] = t
                                .split('Version/')[1]
                                .split(' ')[0]
                                .split('.')
                                .map(e => Number(e));
                            n = e < 16 || (16 === e && r < 2);
                        }
                    }
                    const o = /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(e.navigator.userAgent),
                        i = r();
                    return { isSafari: n || i, needPerspectiveFix: n, need3dFix: i || (o && t.ios), isWebView: o };
                })()),
            um
        );
    }
    var mm = {
        on(e, t, n) {
            const r = this;
            if (!r.eventsListeners || r.destroyed) return r;
            if ('function' != typeof t) return r;
            const o = n ? 'unshift' : 'push';
            return (
                e.split(' ').forEach(e => {
                    (r.eventsListeners[e] || (r.eventsListeners[e] = []), r.eventsListeners[e][o](t));
                }),
                r
            );
        },
        once(e, t, n) {
            const r = this;
            if (!r.eventsListeners || r.destroyed) return r;
            if ('function' != typeof t) return r;
            function o(...n) {
                (r.off(e, o), o.__emitterProxy && delete o.__emitterProxy, t.apply(r, n));
            }
            return ((o.__emitterProxy = t), r.on(e, o, n));
        },
        onAny(e, t) {
            const n = this;
            if (!n.eventsListeners || n.destroyed) return n;
            if ('function' != typeof e) return n;
            const r = t ? 'unshift' : 'push';
            return (n.eventsAnyListeners.indexOf(e) < 0 && n.eventsAnyListeners[r](e), n);
        },
        offAny(e) {
            const t = this;
            if (!t.eventsListeners || t.destroyed) return t;
            if (!t.eventsAnyListeners) return t;
            const n = t.eventsAnyListeners.indexOf(e);
            return (n >= 0 && t.eventsAnyListeners.splice(n, 1), t);
        },
        off(e, t) {
            const n = this;
            return !n.eventsListeners || n.destroyed
                ? n
                : n.eventsListeners
                  ? (e.split(' ').forEach(e => {
                        void 0 === t
                            ? (n.eventsListeners[e] = [])
                            : n.eventsListeners[e] &&
                              n.eventsListeners[e].forEach((r, o) => {
                                  (r === t || (r.__emitterProxy && r.__emitterProxy === t)) &&
                                      n.eventsListeners[e].splice(o, 1);
                              });
                    }),
                    n)
                  : n;
        },
        emit(...e) {
            const t = this;
            if (!t.eventsListeners || t.destroyed) return t;
            if (!t.eventsListeners) return t;
            let n, r, o;
            return (
                'string' == typeof e[0] || Array.isArray(e[0])
                    ? ((n = e[0]), (r = e.slice(1, e.length)), (o = t))
                    : ((n = e[0].events), (r = e[0].data), (o = e[0].context || t)),
                r.unshift(o),
                (Array.isArray(n) ? n : n.split(' ')).forEach(e => {
                    (t.eventsAnyListeners &&
                        t.eventsAnyListeners.length &&
                        t.eventsAnyListeners.forEach(t => {
                            t.apply(o, [e, ...r]);
                        }),
                        t.eventsListeners &&
                            t.eventsListeners[e] &&
                            t.eventsListeners[e].forEach(e => {
                                e.apply(o, r);
                            }));
                }),
                t
            );
        }
    };
    const gm = (e, t, n) => {
            t && !e.classList.contains(n) ? e.classList.add(n) : !t && e.classList.contains(n) && e.classList.remove(n);
        },
        vm = (e, t, n) => {
            t && !e.classList.contains(n) ? e.classList.add(n) : !t && e.classList.contains(n) && e.classList.remove(n);
        },
        ym = (e, t) => {
            if (!e || e.destroyed || !e.params) return;
            const n = t.closest(e.isElement ? 'swiper-slide' : `.${e.params.slideClass}`);
            if (n) {
                let t = n.querySelector(`.${e.params.lazyPreloaderClass}`);
                (!t &&
                    e.isElement &&
                    (n.shadowRoot
                        ? (t = n.shadowRoot.querySelector(`.${e.params.lazyPreloaderClass}`))
                        : requestAnimationFrame(() => {
                              n.shadowRoot &&
                                  ((t = n.shadowRoot.querySelector(`.${e.params.lazyPreloaderClass}`)),
                                  t && t.remove());
                          })),
                    t && t.remove());
            }
        },
        bm = (e, t) => {
            if (!e.slides[t]) return;
            const n = e.slides[t].querySelector('[loading="lazy"]');
            n && n.removeAttribute('loading');
        },
        wm = e => {
            if (!e || e.destroyed || !e.params) return;
            let t = e.params.lazyPreloadPrevNext;
            const n = e.slides.length;
            if (!n || !t || t < 0) return;
            t = Math.min(t, n);
            const r = 'auto' === e.params.slidesPerView ? e.slidesPerViewDynamic() : Math.ceil(e.params.slidesPerView),
                o = e.activeIndex;
            if (e.params.grid && e.params.grid.rows > 1) {
                const n = o,
                    i = [n - t];
                return (
                    i.push(...Array.from({ length: t }).map((e, t) => n + r + t)),
                    void e.slides.forEach((t, n) => {
                        i.includes(t.column) && bm(e, n);
                    })
                );
            }
            const i = o + r - 1;
            if (e.params.rewind || e.params.loop)
                for (let r = o - t; r <= i + t; r += 1) {
                    const t = ((r % n) + n) % n;
                    (t < o || t > i) && bm(e, t);
                }
            else
                for (let r = Math.max(o - t, 0); r <= Math.min(i + t, n - 1); r += 1)
                    r !== o && (r > i || r < o) && bm(e, r);
        };
    var Sm = {
            updateSize: function () {
                const e = this;
                let t, n;
                const r = e.el;
                ((t = void 0 !== e.params.width && null !== e.params.width ? e.params.width : r.clientWidth),
                    (n = void 0 !== e.params.height && null !== e.params.height ? e.params.height : r.clientHeight),
                    (0 === t && e.isHorizontal()) ||
                        (0 === n && e.isVertical()) ||
                        ((t = t - parseInt(im(r, 'padding-left') || 0, 10) - parseInt(im(r, 'padding-right') || 0, 10)),
                        (n = n - parseInt(im(r, 'padding-top') || 0, 10) - parseInt(im(r, 'padding-bottom') || 0, 10)),
                        Number.isNaN(t) && (t = 0),
                        Number.isNaN(n) && (n = 0),
                        Object.assign(e, { width: t, height: n, size: e.isHorizontal() ? t : n })));
            },
            updateSlides: function () {
                const e = this;
                function t(t, n) {
                    return parseFloat(t.getPropertyValue(e.getDirectionLabel(n)) || 0);
                }
                const n = e.params,
                    { wrapperEl: r, slidesEl: o, rtlTranslate: i, wrongRTL: s } = e,
                    a = e.virtual && n.virtual.enabled,
                    l = a ? e.virtual.slides.length : e.slides.length,
                    c = nm(o, `.${e.params.slideClass}, swiper-slide`),
                    d = a ? e.virtual.slides.length : c.length;
                let u = [];
                const p = [],
                    f = [];
                let h = n.slidesOffsetBefore;
                'function' == typeof h && (h = n.slidesOffsetBefore.call(e));
                let m = n.slidesOffsetAfter;
                'function' == typeof m && (m = n.slidesOffsetAfter.call(e));
                const g = e.snapGrid.length,
                    v = e.slidesGrid.length,
                    y = e.size - h - m;
                let b = n.spaceBetween,
                    w = -h,
                    S = 0,
                    x = 0;
                if (void 0 === y) return;
                ('string' == typeof b && b.indexOf('%') >= 0
                    ? (b = (parseFloat(b.replace('%', '')) / 100) * y)
                    : 'string' == typeof b && (b = parseFloat(b)),
                    (e.virtualSize = -b - h - m),
                    c.forEach(e => {
                        (i ? (e.style.marginLeft = '') : (e.style.marginRight = ''),
                            (e.style.marginBottom = ''),
                            (e.style.marginTop = ''));
                    }),
                    n.centeredSlides &&
                        n.cssMode &&
                        (em(r, '--swiper-centered-offset-before', ''), em(r, '--swiper-centered-offset-after', '')));
                const _ = n.grid && n.grid.rows > 1 && e.grid;
                let T;
                _ ? e.grid.initSlides(c) : e.grid && e.grid.unsetSlides();
                const C =
                    'auto' === n.slidesPerView &&
                    n.breakpoints &&
                    Object.keys(n.breakpoints).filter(e => void 0 !== n.breakpoints[e].slidesPerView).length > 0;
                for (let r = 0; r < d; r += 1) {
                    T = 0;
                    const o = c[r];
                    if (!o || (_ && e.grid.updateSlide(r, o, c), 'none' !== im(o, 'display'))) {
                        if (a && 'auto' === n.slidesPerView)
                            (n.virtual.slidesPerViewAutoSlideSize && (T = n.virtual.slidesPerViewAutoSlideSize),
                                T &&
                                    o &&
                                    (n.roundLengths && (T = Math.floor(T)),
                                    (o.style[e.getDirectionLabel('width')] = `${T}px`)));
                        else if ('auto' === n.slidesPerView) {
                            C && (o.style[e.getDirectionLabel('width')] = '');
                            const r = getComputedStyle(o),
                                i = o.style.transform,
                                s = o.style.webkitTransform;
                            if (
                                (i && (o.style.transform = 'none'),
                                s && (o.style.webkitTransform = 'none'),
                                n.roundLengths)
                            )
                                T = e.isHorizontal() ? am(o, 'width', !0) : am(o, 'height', !0);
                            else {
                                const e = t(r, 'width'),
                                    n = t(r, 'padding-left'),
                                    i = t(r, 'padding-right'),
                                    s = t(r, 'margin-left'),
                                    a = t(r, 'margin-right'),
                                    l = r.getPropertyValue('box-sizing');
                                if (l && 'border-box' === l) T = e + s + a;
                                else {
                                    const { clientWidth: t, offsetWidth: r } = o;
                                    T = e + n + i + s + a + (r - t);
                                }
                            }
                            (i && (o.style.transform = i),
                                s && (o.style.webkitTransform = s),
                                n.roundLengths && (T = Math.floor(T)));
                        } else
                            ((T = (y - (n.slidesPerView - 1) * b) / n.slidesPerView),
                                n.roundLengths && (T = Math.floor(T)),
                                o && (o.style[e.getDirectionLabel('width')] = `${T}px`));
                        (o && (o.swiperSlideSize = T),
                            f.push(T),
                            n.centeredSlides
                                ? ((w = w + T / 2 + S / 2 + b),
                                  0 === S && 0 !== r && (w = w - y / 2 - b),
                                  0 === r && (w = w - y / 2 - b),
                                  Math.abs(w) < 0.001 && (w = 0),
                                  n.roundLengths && (w = Math.floor(w)),
                                  x % n.slidesPerGroup === 0 && u.push(w),
                                  p.push(w))
                                : (n.roundLengths && (w = Math.floor(w)),
                                  (x - Math.min(e.params.slidesPerGroupSkip, x)) % e.params.slidesPerGroup === 0 &&
                                      u.push(w),
                                  p.push(w),
                                  (w = w + T + b)),
                            (e.virtualSize += T + b),
                            (S = T),
                            (x += 1));
                    }
                }
                if (
                    ((e.virtualSize = Math.max(e.virtualSize, y) + m),
                    i &&
                        s &&
                        ('slide' === n.effect || 'coverflow' === n.effect) &&
                        (r.style.width = `${e.virtualSize + b}px`),
                    n.setWrapperSize && (r.style[e.getDirectionLabel('width')] = `${e.virtualSize + b}px`),
                    _ && e.grid.updateWrapperSize(T, u),
                    !n.centeredSlides)
                ) {
                    const t = [];
                    for (let r = 0; r < u.length; r += 1) {
                        let o = u[r];
                        (n.roundLengths && (o = Math.floor(o)), u[r] <= e.virtualSize - y && t.push(o));
                    }
                    ((u = t),
                        Math.floor(e.virtualSize - y) - Math.floor(u[u.length - 1]) > 1 && u.push(e.virtualSize - y));
                }
                if (a && n.loop) {
                    const t = f[0] + b;
                    if (n.slidesPerGroup > 1) {
                        const r = Math.ceil((e.virtual.slidesBefore + e.virtual.slidesAfter) / n.slidesPerGroup),
                            o = t * n.slidesPerGroup;
                        for (let e = 0; e < r; e += 1) u.push(u[u.length - 1] + o);
                    }
                    for (let r = 0; r < e.virtual.slidesBefore + e.virtual.slidesAfter; r += 1)
                        (1 === n.slidesPerGroup && u.push(u[u.length - 1] + t),
                            p.push(p[p.length - 1] + t),
                            (e.virtualSize += t));
                }
                if ((0 === u.length && (u = [0]), 0 !== b)) {
                    const t = e.isHorizontal() && i ? 'marginLeft' : e.getDirectionLabel('marginRight');
                    c.filter((e, t) => !(n.cssMode && !n.loop) || t !== c.length - 1).forEach(e => {
                        e.style[t] = `${b}px`;
                    });
                }
                if (n.centeredSlides && n.centeredSlidesBounds) {
                    let e = 0;
                    (f.forEach(t => {
                        e += t + (b || 0);
                    }),
                        (e -= b));
                    const t = e > y ? e - y : 0;
                    u = u.map(e => (e <= 0 ? -h : e > t ? t + m : e));
                }
                if (n.centerInsufficientSlides) {
                    let e = 0;
                    (f.forEach(t => {
                        e += t + (b || 0);
                    }),
                        (e -= b));
                    const t = (h || 0) + (m || 0);
                    if (e + t < y) {
                        const n = (y - e - t) / 2;
                        (u.forEach((e, t) => {
                            u[t] = e - n;
                        }),
                            p.forEach((e, t) => {
                                p[t] = e + n;
                            }));
                    }
                }
                if (
                    (Object.assign(e, { slides: c, snapGrid: u, slidesGrid: p, slidesSizesGrid: f }),
                    n.centeredSlides && n.cssMode && !n.centeredSlidesBounds)
                ) {
                    (em(r, '--swiper-centered-offset-before', -u[0] + 'px'),
                        em(r, '--swiper-centered-offset-after', e.size / 2 - f[f.length - 1] / 2 + 'px'));
                    const t = -e.snapGrid[0],
                        n = -e.slidesGrid[0];
                    ((e.snapGrid = e.snapGrid.map(e => e + t)), (e.slidesGrid = e.slidesGrid.map(e => e + n)));
                }
                if (
                    (d !== l && e.emit('slidesLengthChange'),
                    u.length !== g && (e.params.watchOverflow && e.checkOverflow(), e.emit('snapGridLengthChange')),
                    p.length !== v && e.emit('slidesGridLengthChange'),
                    n.watchSlidesProgress && e.updateSlidesOffset(),
                    e.emit('slidesUpdated'),
                    !(a || n.cssMode || ('slide' !== n.effect && 'fade' !== n.effect)))
                ) {
                    const t = `${n.containerModifierClass}backface-hidden`,
                        r = e.el.classList.contains(t);
                    d <= n.maxBackfaceHiddenSlides ? r || e.el.classList.add(t) : r && e.el.classList.remove(t);
                }
            },
            updateAutoHeight: function (e) {
                const t = this,
                    n = [],
                    r = t.virtual && t.params.virtual.enabled;
                let o,
                    i = 0;
                'number' == typeof e ? t.setTransition(e) : !0 === e && t.setTransition(t.params.speed);
                const s = e => (r ? t.slides[t.getSlideIndexByData(e)] : t.slides[e]);
                if ('auto' !== t.params.slidesPerView && t.params.slidesPerView > 1)
                    if (t.params.centeredSlides)
                        (t.visibleSlides || []).forEach(e => {
                            n.push(e);
                        });
                    else
                        for (o = 0; o < Math.ceil(t.params.slidesPerView); o += 1) {
                            const e = t.activeIndex + o;
                            if (e > t.slides.length && !r) break;
                            n.push(s(e));
                        }
                else n.push(s(t.activeIndex));
                for (o = 0; o < n.length; o += 1)
                    if (void 0 !== n[o]) {
                        const e = n[o].offsetHeight;
                        i = e > i ? e : i;
                    }
                (i || 0 === i) && (t.wrapperEl.style.height = `${i}px`);
            },
            updateSlidesOffset: function () {
                const e = this,
                    t = e.slides,
                    n = e.isElement ? (e.isHorizontal() ? e.wrapperEl.offsetLeft : e.wrapperEl.offsetTop) : 0;
                for (let r = 0; r < t.length; r += 1)
                    t[r].swiperSlideOffset =
                        (e.isHorizontal() ? t[r].offsetLeft : t[r].offsetTop) - n - e.cssOverflowAdjustment();
            },
            updateSlidesProgress: function (e = (this && this.translate) || 0) {
                const t = this,
                    n = t.params,
                    { slides: r, rtlTranslate: o, snapGrid: i } = t;
                if (0 === r.length) return;
                void 0 === r[0].swiperSlideOffset && t.updateSlidesOffset();
                let s = -e;
                (o && (s = e), (t.visibleSlidesIndexes = []), (t.visibleSlides = []));
                let a = n.spaceBetween;
                'string' == typeof a && a.indexOf('%') >= 0
                    ? (a = (parseFloat(a.replace('%', '')) / 100) * t.size)
                    : 'string' == typeof a && (a = parseFloat(a));
                for (let e = 0; e < r.length; e += 1) {
                    const l = r[e];
                    let c = l.swiperSlideOffset;
                    n.cssMode && n.centeredSlides && (c -= r[0].swiperSlideOffset);
                    const d = (s + (n.centeredSlides ? t.minTranslate() : 0) - c) / (l.swiperSlideSize + a),
                        u = (s - i[0] + (n.centeredSlides ? t.minTranslate() : 0) - c) / (l.swiperSlideSize + a),
                        p = -(s - c),
                        f = p + t.slidesSizesGrid[e],
                        h = p >= 0 && p <= t.size - t.slidesSizesGrid[e],
                        m = (p >= 0 && p < t.size - 1) || (f > 1 && f <= t.size) || (p <= 0 && f >= t.size);
                    (m && (t.visibleSlides.push(l), t.visibleSlidesIndexes.push(e)),
                        gm(l, m, n.slideVisibleClass),
                        gm(l, h, n.slideFullyVisibleClass),
                        (l.progress = o ? -d : d),
                        (l.originalProgress = o ? -u : u));
                }
            },
            updateProgress: function (e) {
                const t = this;
                if (void 0 === e) {
                    const n = t.rtlTranslate ? -1 : 1;
                    e = (t && t.translate && t.translate * n) || 0;
                }
                const n = t.params,
                    r = t.maxTranslate() - t.minTranslate();
                let { progress: o, isBeginning: i, isEnd: s, progressLoop: a } = t;
                const l = i,
                    c = s;
                if (0 === r) ((o = 0), (i = !0), (s = !0));
                else {
                    o = (e - t.minTranslate()) / r;
                    const n = Math.abs(e - t.minTranslate()) < 1,
                        a = Math.abs(e - t.maxTranslate()) < 1;
                    ((i = n || o <= 0), (s = a || o >= 1), n && (o = 0), a && (o = 1));
                }
                if (n.loop) {
                    const n = t.getSlideIndexByData(0),
                        r = t.getSlideIndexByData(t.slides.length - 1),
                        o = t.slidesGrid[n],
                        i = t.slidesGrid[r],
                        s = t.slidesGrid[t.slidesGrid.length - 1],
                        l = Math.abs(e);
                    ((a = l >= o ? (l - o) / s : (l + s - i) / s), a > 1 && (a -= 1));
                }
                (Object.assign(t, { progress: o, progressLoop: a, isBeginning: i, isEnd: s }),
                    (n.watchSlidesProgress || (n.centeredSlides && n.autoHeight)) && t.updateSlidesProgress(e),
                    i && !l && t.emit('reachBeginning toEdge'),
                    s && !c && t.emit('reachEnd toEdge'),
                    ((l && !i) || (c && !s)) && t.emit('fromEdge'),
                    t.emit('progress', o));
            },
            updateSlidesClasses: function () {
                const e = this,
                    { slides: t, params: n, slidesEl: r, activeIndex: o } = e,
                    i = e.virtual && n.virtual.enabled,
                    s = e.grid && n.grid && n.grid.rows > 1,
                    a = e => nm(r, `.${n.slideClass}${e}, swiper-slide${e}`)[0];
                let l, c, d;
                if (i)
                    if (n.loop) {
                        let t = o - e.virtual.slidesBefore;
                        (t < 0 && (t = e.virtual.slides.length + t),
                            t >= e.virtual.slides.length && (t -= e.virtual.slides.length),
                            (l = a(`[data-swiper-slide-index="${t}"]`)));
                    } else l = a(`[data-swiper-slide-index="${o}"]`);
                else
                    s
                        ? ((l = t.find(e => e.column === o)),
                          (d = t.find(e => e.column === o + 1)),
                          (c = t.find(e => e.column === o - 1)))
                        : (l = t[o]);
                (l &&
                    (s ||
                        ((d = (function (e, t) {
                            const n = [];
                            for (; e.nextElementSibling; ) {
                                const r = e.nextElementSibling;
                                (t ? r.matches(t) && n.push(r) : n.push(r), (e = r));
                            }
                            return n;
                        })(l, `.${n.slideClass}, swiper-slide`)[0]),
                        n.loop && !d && (d = t[0]),
                        (c = (function (e, t) {
                            const n = [];
                            for (; e.previousElementSibling; ) {
                                const r = e.previousElementSibling;
                                (t ? r.matches(t) && n.push(r) : n.push(r), (e = r));
                            }
                            return n;
                        })(l, `.${n.slideClass}, swiper-slide`)[0]),
                        n.loop && 0 === !c && (c = t[t.length - 1]))),
                    t.forEach(e => {
                        (vm(e, e === l, n.slideActiveClass),
                            vm(e, e === d, n.slideNextClass),
                            vm(e, e === c, n.slidePrevClass));
                    }),
                    e.emitSlidesClasses());
            },
            updateActiveIndex: function (e) {
                const t = this,
                    n = t.rtlTranslate ? t.translate : -t.translate,
                    { snapGrid: r, params: o, activeIndex: i, realIndex: s, snapIndex: a } = t;
                let l,
                    c = e;
                const d = e => {
                    let n = e - t.virtual.slidesBefore;
                    return (
                        n < 0 && (n = t.virtual.slides.length + n),
                        n >= t.virtual.slides.length && (n -= t.virtual.slides.length),
                        n
                    );
                };
                if (
                    (void 0 === c &&
                        (c = (function (e) {
                            const { slidesGrid: t, params: n } = e,
                                r = e.rtlTranslate ? e.translate : -e.translate;
                            let o;
                            for (let e = 0; e < t.length; e += 1)
                                void 0 !== t[e + 1]
                                    ? r >= t[e] && r < t[e + 1] - (t[e + 1] - t[e]) / 2
                                        ? (o = e)
                                        : r >= t[e] && r < t[e + 1] && (o = e + 1)
                                    : r >= t[e] && (o = e);
                            return (n.normalizeSlideIndex && (o < 0 || void 0 === o) && (o = 0), o);
                        })(t)),
                    r.indexOf(n) >= 0)
                )
                    l = r.indexOf(n);
                else {
                    const e = Math.min(o.slidesPerGroupSkip, c);
                    l = e + Math.floor((c - e) / o.slidesPerGroup);
                }
                if ((l >= r.length && (l = r.length - 1), c === i && !t.params.loop))
                    return void (l !== a && ((t.snapIndex = l), t.emit('snapIndexChange')));
                if (c === i && t.params.loop && t.virtual && t.params.virtual.enabled) return void (t.realIndex = d(c));
                const u = t.grid && o.grid && o.grid.rows > 1;
                let p;
                if (t.virtual && o.virtual.enabled && o.loop) p = d(c);
                else if (u) {
                    const e = t.slides.find(e => e.column === c);
                    let n = parseInt(e.getAttribute('data-swiper-slide-index'), 10);
                    (Number.isNaN(n) && (n = Math.max(t.slides.indexOf(e), 0)), (p = Math.floor(n / o.grid.rows)));
                } else if (t.slides[c]) {
                    const e = t.slides[c].getAttribute('data-swiper-slide-index');
                    p = e ? parseInt(e, 10) : c;
                } else p = c;
                (Object.assign(t, {
                    previousSnapIndex: a,
                    snapIndex: l,
                    previousRealIndex: s,
                    realIndex: p,
                    previousIndex: i,
                    activeIndex: c
                }),
                    t.initialized && wm(t),
                    t.emit('activeIndexChange'),
                    t.emit('snapIndexChange'),
                    (t.initialized || t.params.runCallbacksOnInit) &&
                        (s !== p && t.emit('realIndexChange'), t.emit('slideChange')));
            },
            updateClickedSlide: function (e, t) {
                const n = this,
                    r = n.params;
                let o = e.closest(`.${r.slideClass}, swiper-slide`);
                !o &&
                    n.isElement &&
                    t &&
                    t.length > 1 &&
                    t.includes(e) &&
                    [...t.slice(t.indexOf(e) + 1, t.length)].forEach(e => {
                        !o && e.matches && e.matches(`.${r.slideClass}, swiper-slide`) && (o = e);
                    });
                let i,
                    s = !1;
                if (o)
                    for (let e = 0; e < n.slides.length; e += 1)
                        if (n.slides[e] === o) {
                            ((s = !0), (i = e));
                            break;
                        }
                if (!o || !s) return ((n.clickedSlide = void 0), void (n.clickedIndex = void 0));
                ((n.clickedSlide = o),
                    n.virtual && n.params.virtual.enabled
                        ? (n.clickedIndex = parseInt(o.getAttribute('data-swiper-slide-index'), 10))
                        : (n.clickedIndex = i),
                    r.slideToClickedSlide &&
                        void 0 !== n.clickedIndex &&
                        n.clickedIndex !== n.activeIndex &&
                        n.slideToClickedSlide());
            }
        },
        xm = {
            getTranslate: function (e = this.isHorizontal() ? 'x' : 'y') {
                const { params: t, rtlTranslate: n, translate: r, wrapperEl: o } = this;
                if (t.virtualTranslate) return n ? -r : r;
                if (t.cssMode) return r;
                let i = (function (e, t = 'x') {
                    const n = Yh();
                    let r, o, i;
                    const s = (function (e) {
                        const t = Yh();
                        let n;
                        return (
                            t.getComputedStyle && (n = t.getComputedStyle(e, null)),
                            !n && e.currentStyle && (n = e.currentStyle),
                            n || (n = e.style),
                            n
                        );
                    })(e);
                    return (
                        n.WebKitCSSMatrix
                            ? ((o = s.transform || s.webkitTransform),
                              o.split(',').length > 6 &&
                                  (o = o
                                      .split(', ')
                                      .map(e => e.replace(',', '.'))
                                      .join(', ')),
                              (i = new n.WebKitCSSMatrix('none' === o ? '' : o)))
                            : ((i =
                                  s.MozTransform ||
                                  s.OTransform ||
                                  s.MsTransform ||
                                  s.msTransform ||
                                  s.transform ||
                                  s.getPropertyValue('transform').replace('translate(', 'matrix(1, 0, 0, 1,')),
                              (r = i.toString().split(','))),
                        'x' === t &&
                            (o = n.WebKitCSSMatrix ? i.m41 : 16 === r.length ? parseFloat(r[12]) : parseFloat(r[4])),
                        'y' === t &&
                            (o = n.WebKitCSSMatrix ? i.m42 : 16 === r.length ? parseFloat(r[13]) : parseFloat(r[5])),
                        o || 0
                    );
                })(o, e);
                return ((i += this.cssOverflowAdjustment()), n && (i = -i), i || 0);
            },
            setTranslate: function (e, t) {
                const n = this,
                    { rtlTranslate: r, params: o, wrapperEl: i, progress: s } = n;
                let a,
                    l = 0,
                    c = 0;
                (n.isHorizontal() ? (l = r ? -e : e) : (c = e),
                    o.roundLengths && ((l = Math.floor(l)), (c = Math.floor(c))),
                    (n.previousTranslate = n.translate),
                    (n.translate = n.isHorizontal() ? l : c),
                    o.cssMode
                        ? (i[n.isHorizontal() ? 'scrollLeft' : 'scrollTop'] = n.isHorizontal() ? -l : -c)
                        : o.virtualTranslate ||
                          (n.isHorizontal() ? (l -= n.cssOverflowAdjustment()) : (c -= n.cssOverflowAdjustment()),
                          (i.style.transform = `translate3d(${l}px, ${c}px, 0px)`)));
                const d = n.maxTranslate() - n.minTranslate();
                ((a = 0 === d ? 0 : (e - n.minTranslate()) / d),
                    a !== s && n.updateProgress(e),
                    n.emit('setTranslate', n.translate, t));
            },
            minTranslate: function () {
                return -this.snapGrid[0];
            },
            maxTranslate: function () {
                return -this.snapGrid[this.snapGrid.length - 1];
            },
            translateTo: function (e = 0, t = this.params.speed, n = !0, r = !0, o) {
                const i = this,
                    { params: s, wrapperEl: a } = i;
                if (i.animating && s.preventInteractionOnTransition) return !1;
                const l = i.minTranslate(),
                    c = i.maxTranslate();
                let d;
                if (((d = r && e > l ? l : r && e < c ? c : e), i.updateProgress(d), s.cssMode)) {
                    const e = i.isHorizontal();
                    if (0 === t) a[e ? 'scrollLeft' : 'scrollTop'] = -d;
                    else {
                        if (!i.support.smoothScroll)
                            return (tm({ swiper: i, targetPosition: -d, side: e ? 'left' : 'top' }), !0);
                        a.scrollTo({ [e ? 'left' : 'top']: -d, behavior: 'smooth' });
                    }
                    return !0;
                }
                return (
                    0 === t
                        ? (i.setTransition(0),
                          i.setTranslate(d),
                          n && (i.emit('beforeTransitionStart', t, o), i.emit('transitionEnd')))
                        : (i.setTransition(t),
                          i.setTranslate(d),
                          n && (i.emit('beforeTransitionStart', t, o), i.emit('transitionStart')),
                          i.animating ||
                              ((i.animating = !0),
                              i.onTranslateToWrapperTransitionEnd ||
                                  (i.onTranslateToWrapperTransitionEnd = function (e) {
                                      i &&
                                          !i.destroyed &&
                                          e.target === this &&
                                          (i.wrapperEl.removeEventListener(
                                              'transitionend',
                                              i.onTranslateToWrapperTransitionEnd
                                          ),
                                          (i.onTranslateToWrapperTransitionEnd = null),
                                          delete i.onTranslateToWrapperTransitionEnd,
                                          (i.animating = !1),
                                          n && i.emit('transitionEnd'));
                                  }),
                              i.wrapperEl.addEventListener('transitionend', i.onTranslateToWrapperTransitionEnd))),
                    !0
                );
            }
        };
    function _m({ swiper: e, runCallbacks: t, direction: n, step: r }) {
        const { activeIndex: o, previousIndex: i } = e;
        let s = n;
        (s || (s = o > i ? 'next' : o < i ? 'prev' : 'reset'),
            e.emit(`transition${r}`),
            t && 'reset' === s
                ? e.emit(`slideResetTransition${r}`)
                : t &&
                  o !== i &&
                  (e.emit(`slideChangeTransition${r}`),
                  'next' === s ? e.emit(`slideNextTransition${r}`) : e.emit(`slidePrevTransition${r}`)));
    }
    var Tm = {
            setTransition: function (e, t) {
                const n = this;
                (n.params.cssMode ||
                    ((n.wrapperEl.style.transitionDuration = `${e}ms`),
                    (n.wrapperEl.style.transitionDelay = 0 === e ? '0ms' : '')),
                    n.emit('setTransition', e, t));
            },
            transitionStart: function (e = !0, t) {
                const n = this,
                    { params: r } = n;
                r.cssMode ||
                    (r.autoHeight && n.updateAutoHeight(),
                    _m({ swiper: n, runCallbacks: e, direction: t, step: 'Start' }));
            },
            transitionEnd: function (e = !0, t) {
                const n = this,
                    { params: r } = n;
                ((n.animating = !1),
                    r.cssMode || (n.setTransition(0), _m({ swiper: n, runCallbacks: e, direction: t, step: 'End' })));
            }
        },
        Cm = {
            slideTo: function (e = 0, t, n = !0, r, o) {
                'string' == typeof e && (e = parseInt(e, 10));
                const i = this;
                let s = e;
                s < 0 && (s = 0);
                const {
                    params: a,
                    snapGrid: l,
                    slidesGrid: c,
                    previousIndex: d,
                    activeIndex: u,
                    rtlTranslate: p,
                    wrapperEl: f,
                    enabled: h
                } = i;
                if ((!h && !r && !o) || i.destroyed || (i.animating && a.preventInteractionOnTransition)) return !1;
                void 0 === t && (t = i.params.speed);
                const m = Math.min(i.params.slidesPerGroupSkip, s);
                let g = m + Math.floor((s - m) / i.params.slidesPerGroup);
                g >= l.length && (g = l.length - 1);
                const v = -l[g];
                if (a.normalizeSlideIndex)
                    for (let e = 0; e < c.length; e += 1) {
                        const t = -Math.floor(100 * v),
                            n = Math.floor(100 * c[e]),
                            r = Math.floor(100 * c[e + 1]);
                        void 0 !== c[e + 1]
                            ? t >= n && t < r - (r - n) / 2
                                ? (s = e)
                                : t >= n && t < r && (s = e + 1)
                            : t >= n && (s = e);
                    }
                if (i.initialized && s !== u) {
                    if (
                        !i.allowSlideNext &&
                        (p ? v > i.translate && v > i.minTranslate() : v < i.translate && v < i.minTranslate())
                    )
                        return !1;
                    if (!i.allowSlidePrev && v > i.translate && v > i.maxTranslate() && (u || 0) !== s) return !1;
                }
                let y;
                (s !== (d || 0) && n && i.emit('beforeSlideChangeStart'),
                    i.updateProgress(v),
                    (y = s > u ? 'next' : s < u ? 'prev' : 'reset'));
                const b = i.virtual && i.params.virtual.enabled;
                if ((!b || !o) && ((p && -v === i.translate) || (!p && v === i.translate)))
                    return (
                        i.updateActiveIndex(s),
                        a.autoHeight && i.updateAutoHeight(),
                        i.updateSlidesClasses(),
                        'slide' !== a.effect && i.setTranslate(v),
                        'reset' !== y && (i.transitionStart(n, y), i.transitionEnd(n, y)),
                        !1
                    );
                if (a.cssMode) {
                    const e = i.isHorizontal(),
                        n = p ? v : -v;
                    if (0 === t)
                        (b && ((i.wrapperEl.style.scrollSnapType = 'none'), (i._immediateVirtual = !0)),
                            b && !i._cssModeVirtualInitialSet && i.params.initialSlide > 0
                                ? ((i._cssModeVirtualInitialSet = !0),
                                  requestAnimationFrame(() => {
                                      f[e ? 'scrollLeft' : 'scrollTop'] = n;
                                  }))
                                : (f[e ? 'scrollLeft' : 'scrollTop'] = n),
                            b &&
                                requestAnimationFrame(() => {
                                    ((i.wrapperEl.style.scrollSnapType = ''), (i._immediateVirtual = !1));
                                }));
                    else {
                        if (!i.support.smoothScroll)
                            return (tm({ swiper: i, targetPosition: n, side: e ? 'left' : 'top' }), !0);
                        f.scrollTo({ [e ? 'left' : 'top']: n, behavior: 'smooth' });
                    }
                    return !0;
                }
                const w = hm().isSafari;
                return (
                    b && !o && w && i.isElement && i.virtual.update(!1, !1, s),
                    i.setTransition(t),
                    i.setTranslate(v),
                    i.updateActiveIndex(s),
                    i.updateSlidesClasses(),
                    i.emit('beforeTransitionStart', t, r),
                    i.transitionStart(n, y),
                    0 === t
                        ? i.transitionEnd(n, y)
                        : i.animating ||
                          ((i.animating = !0),
                          i.onSlideToWrapperTransitionEnd ||
                              (i.onSlideToWrapperTransitionEnd = function (e) {
                                  i &&
                                      !i.destroyed &&
                                      e.target === this &&
                                      (i.wrapperEl.removeEventListener(
                                          'transitionend',
                                          i.onSlideToWrapperTransitionEnd
                                      ),
                                      (i.onSlideToWrapperTransitionEnd = null),
                                      delete i.onSlideToWrapperTransitionEnd,
                                      i.transitionEnd(n, y));
                              }),
                          i.wrapperEl.addEventListener('transitionend', i.onSlideToWrapperTransitionEnd)),
                    !0
                );
            },
            slideToLoop: function (e = 0, t, n = !0, r) {
                'string' == typeof e && (e = parseInt(e, 10));
                const o = this;
                if (o.destroyed) return;
                void 0 === t && (t = o.params.speed);
                const i = o.grid && o.params.grid && o.params.grid.rows > 1;
                let s = e;
                if (o.params.loop)
                    if (o.virtual && o.params.virtual.enabled) s += o.virtual.slidesBefore;
                    else {
                        let e;
                        if (i) {
                            const t = s * o.params.grid.rows;
                            e = o.slides.find(e => 1 * e.getAttribute('data-swiper-slide-index') === t).column;
                        } else e = o.getSlideIndexByData(s);
                        const t = i ? Math.ceil(o.slides.length / o.params.grid.rows) : o.slides.length,
                            { centeredSlides: n, slidesOffsetBefore: a, slidesOffsetAfter: l } = o.params,
                            c = n || !!a || !!l;
                        let d = o.params.slidesPerView;
                        'auto' === d
                            ? (d = o.slidesPerViewDynamic())
                            : ((d = Math.ceil(parseFloat(o.params.slidesPerView, 10))), c && d % 2 == 0 && (d += 1));
                        let u = t - e < d;
                        if (
                            (c && (u = u || e < Math.ceil(d / 2)),
                            r && c && 'auto' !== o.params.slidesPerView && !i && (u = !1),
                            u)
                        ) {
                            const n = c
                                ? e < o.activeIndex
                                    ? 'prev'
                                    : 'next'
                                : e - o.activeIndex - 1 < o.params.slidesPerView
                                  ? 'next'
                                  : 'prev';
                            o.loopFix({
                                direction: n,
                                slideTo: !0,
                                activeSlideIndex: 'next' === n ? e + 1 : e - t + 1,
                                slideRealIndex: 'next' === n ? o.realIndex : void 0
                            });
                        }
                        if (i) {
                            const e = s * o.params.grid.rows;
                            s = o.slides.find(t => 1 * t.getAttribute('data-swiper-slide-index') === e).column;
                        } else s = o.getSlideIndexByData(s);
                    }
                return (
                    requestAnimationFrame(() => {
                        o.slideTo(s, t, n, r);
                    }),
                    o
                );
            },
            slideNext: function (e, t = !0, n) {
                const r = this,
                    { enabled: o, params: i, animating: s } = r;
                if (!o || r.destroyed) return r;
                void 0 === e && (e = r.params.speed);
                let a = i.slidesPerGroup;
                'auto' === i.slidesPerView &&
                    1 === i.slidesPerGroup &&
                    i.slidesPerGroupAuto &&
                    (a = Math.max(r.slidesPerViewDynamic('current', !0), 1));
                const l = r.activeIndex < i.slidesPerGroupSkip ? 1 : a,
                    c = r.virtual && i.virtual.enabled;
                if (i.loop) {
                    if (s && !c && i.loopPreventsSliding) return !1;
                    if (
                        (r.loopFix({ direction: 'next' }),
                        (r._clientLeft = r.wrapperEl.clientLeft),
                        r.activeIndex === r.slides.length - 1 && i.cssMode)
                    )
                        return (
                            requestAnimationFrame(() => {
                                r.slideTo(r.activeIndex + l, e, t, n);
                            }),
                            !0
                        );
                }
                return i.rewind && r.isEnd ? r.slideTo(0, e, t, n) : r.slideTo(r.activeIndex + l, e, t, n);
            },
            slidePrev: function (e, t = !0, n) {
                const r = this,
                    { params: o, snapGrid: i, slidesGrid: s, rtlTranslate: a, enabled: l, animating: c } = r;
                if (!l || r.destroyed) return r;
                void 0 === e && (e = r.params.speed);
                const d = r.virtual && o.virtual.enabled;
                if (o.loop) {
                    if (c && !d && o.loopPreventsSliding) return !1;
                    (r.loopFix({ direction: 'prev' }), (r._clientLeft = r.wrapperEl.clientLeft));
                }
                function u(e) {
                    return e < 0 ? -Math.floor(Math.abs(e)) : Math.floor(e);
                }
                const p = u(a ? r.translate : -r.translate),
                    f = i.map(e => u(e)),
                    h = o.freeMode && o.freeMode.enabled;
                let m = i[f.indexOf(p) - 1];
                if (void 0 === m && (o.cssMode || h)) {
                    let e;
                    (i.forEach((t, n) => {
                        p >= t && (e = n);
                    }),
                        void 0 !== e && (m = h ? i[e] : i[e > 0 ? e - 1 : e]));
                }
                let g = 0;
                if (
                    (void 0 !== m &&
                        ((g = s.indexOf(m)),
                        g < 0 && (g = r.activeIndex - 1),
                        'auto' === o.slidesPerView &&
                            1 === o.slidesPerGroup &&
                            o.slidesPerGroupAuto &&
                            ((g = g - r.slidesPerViewDynamic('previous', !0) + 1), (g = Math.max(g, 0)))),
                    o.rewind && r.isBeginning)
                ) {
                    const o =
                        r.params.virtual && r.params.virtual.enabled && r.virtual
                            ? r.virtual.slides.length - 1
                            : r.slides.length - 1;
                    return r.slideTo(o, e, t, n);
                }
                return o.loop && 0 === r.activeIndex && o.cssMode
                    ? (requestAnimationFrame(() => {
                          r.slideTo(g, e, t, n);
                      }),
                      !0)
                    : r.slideTo(g, e, t, n);
            },
            slideReset: function (e, t = !0, n) {
                const r = this;
                if (!r.destroyed) return (void 0 === e && (e = r.params.speed), r.slideTo(r.activeIndex, e, t, n));
            },
            slideToClosest: function (e, t = !0, n, r = 0.5) {
                const o = this;
                if (o.destroyed) return;
                void 0 === e && (e = o.params.speed);
                let i = o.activeIndex;
                const s = Math.min(o.params.slidesPerGroupSkip, i),
                    a = s + Math.floor((i - s) / o.params.slidesPerGroup),
                    l = o.rtlTranslate ? o.translate : -o.translate;
                if (l >= o.snapGrid[a]) {
                    const e = o.snapGrid[a];
                    l - e > (o.snapGrid[a + 1] - e) * r && (i += o.params.slidesPerGroup);
                } else {
                    const e = o.snapGrid[a - 1];
                    l - e <= (o.snapGrid[a] - e) * r && (i -= o.params.slidesPerGroup);
                }
                return ((i = Math.max(i, 0)), (i = Math.min(i, o.slidesGrid.length - 1)), o.slideTo(i, e, t, n));
            },
            slideToClickedSlide: function () {
                const e = this;
                if (e.destroyed) return;
                const { params: t, slidesEl: n } = e,
                    r = 'auto' === t.slidesPerView ? e.slidesPerViewDynamic() : t.slidesPerView;
                let o,
                    i = e.getSlideIndexWhenGrid(e.clickedIndex);
                const s = e.isElement ? 'swiper-slide' : `.${t.slideClass}`,
                    a = e.grid && e.params.grid && e.params.grid.rows > 1;
                if (t.loop) {
                    if (e.animating) return;
                    ((o = parseInt(e.clickedSlide.getAttribute('data-swiper-slide-index'), 10)),
                        t.centeredSlides
                            ? e.slideToLoop(o)
                            : i > (a ? (e.slides.length - r) / 2 - (e.params.grid.rows - 1) : e.slides.length - r)
                              ? (e.loopFix(),
                                (i = e.getSlideIndex(nm(n, `${s}[data-swiper-slide-index="${o}"]`)[0])),
                                Kh(() => {
                                    e.slideTo(i);
                                }))
                              : e.slideTo(i));
                } else e.slideTo(i);
            }
        },
        km = {
            loopCreate: function (e, t) {
                const n = this,
                    { params: r, slidesEl: o } = n;
                if (!r.loop || (n.virtual && n.params.virtual.enabled)) return;
                const i = () => {
                        nm(o, `.${r.slideClass}, swiper-slide`).forEach((e, t) => {
                            e.setAttribute('data-swiper-slide-index', t);
                        });
                    },
                    s = n.grid && r.grid && r.grid.rows > 1;
                r.loopAddBlankSlides &&
                    (r.slidesPerGroup > 1 || s) &&
                    (() => {
                        const e = nm(o, `.${r.slideBlankClass}`);
                        (e.forEach(e => {
                            e.remove();
                        }),
                            e.length > 0 && (n.recalcSlides(), n.updateSlides()));
                    })();
                const a = r.slidesPerGroup * (s ? r.grid.rows : 1),
                    l = n.slides.length % a !== 0,
                    c = s && n.slides.length % r.grid.rows !== 0,
                    d = e => {
                        for (let t = 0; t < e; t += 1) {
                            const e = n.isElement
                                ? om('swiper-slide', [r.slideBlankClass])
                                : om('div', [r.slideClass, r.slideBlankClass]);
                            n.slidesEl.append(e);
                        }
                    };
                l
                    ? (r.loopAddBlankSlides
                          ? (d(a - (n.slides.length % a)), n.recalcSlides(), n.updateSlides())
                          : rm(
                                'Swiper Loop Warning: The number of slides is not even to slidesPerGroup, loop mode may not function properly. You need to add more slides (or make duplicates, or empty slides)'
                            ),
                      i())
                    : c
                      ? (r.loopAddBlankSlides
                            ? (d(r.grid.rows - (n.slides.length % r.grid.rows)), n.recalcSlides(), n.updateSlides())
                            : rm(
                                  'Swiper Loop Warning: The number of slides is not even to grid.rows, loop mode may not function properly. You need to add more slides (or make duplicates, or empty slides)'
                              ),
                        i())
                      : i();
                const u = r.centeredSlides || !!r.slidesOffsetBefore || !!r.slidesOffsetAfter;
                n.loopFix({ slideRealIndex: e, direction: u ? void 0 : 'next', initial: t });
            },
            loopFix: function ({
                slideRealIndex: e,
                slideTo: t = !0,
                direction: n,
                setTranslate: r,
                activeSlideIndex: o,
                initial: i,
                byController: s,
                byMousewheel: a
            } = {}) {
                const l = this;
                if (!l.params.loop) return;
                l.emit('beforeLoopFix');
                const { slides: c, allowSlidePrev: d, allowSlideNext: u, slidesEl: p, params: f } = l,
                    { centeredSlides: h, slidesOffsetBefore: m, slidesOffsetAfter: g, initialSlide: v } = f,
                    y = h || !!m || !!g;
                if (((l.allowSlidePrev = !0), (l.allowSlideNext = !0), l.virtual && f.virtual.enabled))
                    return (
                        t &&
                            (y || 0 !== l.snapIndex
                                ? y && l.snapIndex < f.slidesPerView
                                    ? l.slideTo(l.virtual.slides.length + l.snapIndex, 0, !1, !0)
                                    : l.snapIndex === l.snapGrid.length - 1 &&
                                      l.slideTo(l.virtual.slidesBefore, 0, !1, !0)
                                : l.slideTo(l.virtual.slides.length, 0, !1, !0)),
                        (l.allowSlidePrev = d),
                        (l.allowSlideNext = u),
                        void l.emit('loopFix')
                    );
                let b = f.slidesPerView;
                'auto' === b
                    ? (b = l.slidesPerViewDynamic())
                    : ((b = Math.ceil(parseFloat(f.slidesPerView, 10))), y && b % 2 == 0 && (b += 1));
                const w = f.slidesPerGroupAuto ? b : f.slidesPerGroup;
                let S = y ? Math.max(w, Math.ceil(b / 2)) : w;
                (S % w !== 0 && (S += w - (S % w)), (S += f.loopAdditionalSlides), (l.loopedSlides = S));
                const x = l.grid && f.grid && f.grid.rows > 1;
                c.length < b + S || ('cards' === l.params.effect && c.length < b + 2 * S)
                    ? rm(
                          'Swiper Loop Warning: The number of slides is not enough for loop mode, it will be disabled or not function properly. You need to add more slides (or make duplicates) or lower the values of slidesPerView and slidesPerGroup parameters'
                      )
                    : x &&
                      'row' === f.grid.fill &&
                      rm('Swiper Loop Warning: Loop mode is not compatible with grid.fill = `row`');
                const _ = [],
                    T = [],
                    C = x ? Math.ceil(c.length / f.grid.rows) : c.length,
                    k = i && C - v < b && !y;
                let E = k ? v : l.activeIndex;
                void 0 === o ? (o = l.getSlideIndex(c.find(e => e.classList.contains(f.slideActiveClass)))) : (E = o);
                const A = 'next' === n || !n,
                    O = 'prev' === n || !n;
                let I = 0,
                    M = 0;
                const P = (x ? c[o].column : o) + (y && void 0 === r ? -b / 2 + 0.5 : 0);
                if (P < S) {
                    I = Math.max(S - P, w);
                    for (let e = 0; e < S - P; e += 1) {
                        const t = e - Math.floor(e / C) * C;
                        if (x) {
                            const e = C - t - 1;
                            for (let t = c.length - 1; t >= 0; t -= 1) c[t].column === e && _.push(t);
                        } else _.push(C - t - 1);
                    }
                } else if (P + b > C - S) {
                    ((M = Math.max(P - (C - 2 * S), w)), k && (M = Math.max(M, b - C + v + 1)));
                    for (let e = 0; e < M; e += 1) {
                        const t = e - Math.floor(e / C) * C;
                        x
                            ? c.forEach((e, n) => {
                                  e.column === t && T.push(n);
                              })
                            : T.push(t);
                    }
                }
                if (
                    ((l.__preventObserver__ = !0),
                    requestAnimationFrame(() => {
                        l.__preventObserver__ = !1;
                    }),
                    'cards' === l.params.effect &&
                        c.length < b + 2 * S &&
                        (T.includes(o) && T.splice(T.indexOf(o), 1), _.includes(o) && _.splice(_.indexOf(o), 1)),
                    O &&
                        _.forEach(e => {
                            ((c[e].swiperLoopMoveDOM = !0), p.prepend(c[e]), (c[e].swiperLoopMoveDOM = !1));
                        }),
                    A &&
                        T.forEach(e => {
                            ((c[e].swiperLoopMoveDOM = !0), p.append(c[e]), (c[e].swiperLoopMoveDOM = !1));
                        }),
                    l.recalcSlides(),
                    'auto' === f.slidesPerView
                        ? l.updateSlides()
                        : x &&
                          ((_.length > 0 && O) || (T.length > 0 && A)) &&
                          l.slides.forEach((e, t) => {
                              l.grid.updateSlide(t, e, l.slides);
                          }),
                    f.watchSlidesProgress && l.updateSlidesOffset(),
                    t)
                )
                    if (_.length > 0 && O) {
                        if (void 0 === e) {
                            const e = l.slidesGrid[E],
                                t = l.slidesGrid[E + I] - e;
                            a
                                ? l.setTranslate(l.translate - t)
                                : (l.slideTo(E + Math.ceil(I), 0, !1, !0),
                                  r &&
                                      ((l.touchEventsData.startTranslate = l.touchEventsData.startTranslate - t),
                                      (l.touchEventsData.currentTranslate = l.touchEventsData.currentTranslate - t)));
                        } else if (r) {
                            const e = x ? _.length / f.grid.rows : _.length;
                            (l.slideTo(l.activeIndex + e, 0, !1, !0),
                                (l.touchEventsData.currentTranslate = l.translate));
                        }
                    } else if (T.length > 0 && A)
                        if (void 0 === e) {
                            const e = l.slidesGrid[E],
                                t = l.slidesGrid[E - M] - e;
                            a
                                ? l.setTranslate(l.translate - t)
                                : (l.slideTo(E - M, 0, !1, !0),
                                  r &&
                                      ((l.touchEventsData.startTranslate = l.touchEventsData.startTranslate - t),
                                      (l.touchEventsData.currentTranslate = l.touchEventsData.currentTranslate - t)));
                        } else {
                            const e = x ? T.length / f.grid.rows : T.length;
                            l.slideTo(l.activeIndex - e, 0, !1, !0);
                        }
                if (((l.allowSlidePrev = d), (l.allowSlideNext = u), l.controller && l.controller.control && !s)) {
                    const i = {
                        slideRealIndex: e,
                        direction: n,
                        setTranslate: r,
                        activeSlideIndex: o,
                        byController: !0
                    };
                    Array.isArray(l.controller.control)
                        ? l.controller.control.forEach(e => {
                              !e.destroyed &&
                                  e.params.loop &&
                                  e.loopFix({ ...i, slideTo: e.params.slidesPerView === f.slidesPerView && t });
                          })
                        : l.controller.control instanceof l.constructor &&
                          l.controller.control.params.loop &&
                          l.controller.control.loopFix({
                              ...i,
                              slideTo: l.controller.control.params.slidesPerView === f.slidesPerView && t
                          });
                }
                l.emit('loopFix');
            },
            loopDestroy: function () {
                const e = this,
                    { params: t, slidesEl: n } = e;
                if (!t.loop || !n || (e.virtual && e.params.virtual.enabled)) return;
                e.recalcSlides();
                const r = [];
                (e.slides.forEach(e => {
                    const t =
                        void 0 === e.swiperSlideIndex
                            ? 1 * e.getAttribute('data-swiper-slide-index')
                            : e.swiperSlideIndex;
                    r[t] = e;
                }),
                    e.slides.forEach(e => {
                        e.removeAttribute('data-swiper-slide-index');
                    }),
                    r.forEach(e => {
                        n.append(e);
                    }),
                    e.recalcSlides(),
                    e.slideTo(e.realIndex, 0));
            }
        },
        Em = {
            setGrabCursor: function (e) {
                const t = this;
                if (!t.params.simulateTouch || (t.params.watchOverflow && t.isLocked) || t.params.cssMode) return;
                const n = 'container' === t.params.touchEventsTarget ? t.el : t.wrapperEl;
                (t.isElement && (t.__preventObserver__ = !0),
                    (n.style.cursor = 'move'),
                    (n.style.cursor = e ? 'grabbing' : 'grab'),
                    t.isElement &&
                        requestAnimationFrame(() => {
                            t.__preventObserver__ = !1;
                        }));
            },
            unsetGrabCursor: function () {
                const e = this;
                (e.params.watchOverflow && e.isLocked) ||
                    e.params.cssMode ||
                    (e.isElement && (e.__preventObserver__ = !0),
                    (e['container' === e.params.touchEventsTarget ? 'el' : 'wrapperEl'].style.cursor = ''),
                    e.isElement &&
                        requestAnimationFrame(() => {
                            e.__preventObserver__ = !1;
                        }));
            }
        };
    function Am(e, t, n) {
        const r = Yh(),
            { params: o } = e,
            i = o.edgeSwipeDetection,
            s = o.edgeSwipeThreshold;
        return !i || !(n <= s || n >= r.innerWidth - s) || ('prevent' === i && (t.preventDefault(), !0));
    }
    function Om(e) {
        const t = this,
            n = Wh();
        let r = e;
        r.originalEvent && (r = r.originalEvent);
        const o = t.touchEventsData;
        if ('pointerdown' === r.type) {
            if (null !== o.pointerId && o.pointerId !== r.pointerId) return;
            o.pointerId = r.pointerId;
        } else 'touchstart' === r.type && 1 === r.targetTouches.length && (o.touchId = r.targetTouches[0].identifier);
        if ('touchstart' === r.type) return void Am(t, r, r.targetTouches[0].pageX);
        const { params: i, touches: s, enabled: a } = t;
        if (!a) return;
        if (!i.simulateTouch && 'mouse' === r.pointerType) return;
        if (t.animating && i.preventInteractionOnTransition) return;
        !t.animating && i.cssMode && i.loop && t.loopFix();
        let l = r.target;
        if (
            'wrapper' === i.touchEventsTarget &&
            !(function (e, t) {
                const n = Yh();
                let r = t.contains(e);
                return (
                    !r &&
                        n.HTMLSlotElement &&
                        t instanceof HTMLSlotElement &&
                        ((r = [...t.assignedElements()].includes(e)),
                        r ||
                            (r = (function (e, t) {
                                const n = [t];
                                for (; n.length > 0; ) {
                                    const t = n.shift();
                                    if (e === t) return !0;
                                    n.push(
                                        ...t.children,
                                        ...(t.shadowRoot ? t.shadowRoot.children : []),
                                        ...(t.assignedElements ? t.assignedElements() : [])
                                    );
                                }
                            })(e, t))),
                    r
                );
            })(l, t.wrapperEl)
        )
            return;
        if ('which' in r && 3 === r.which) return;
        if ('button' in r && r.button > 0) return;
        if (o.isTouched && o.isMoved) return;
        const c = !!i.noSwipingClass && '' !== i.noSwipingClass,
            d = r.composedPath ? r.composedPath() : r.path;
        c && r.target && r.target.shadowRoot && d && (l = d[0]);
        const u = i.noSwipingSelector ? i.noSwipingSelector : `.${i.noSwipingClass}`,
            p = !(!r.target || !r.target.shadowRoot);
        if (
            i.noSwiping &&
            (p
                ? (function (e, t = this) {
                      return (function t(n) {
                          if (!n || n === Wh() || n === Yh()) return null;
                          n.assignedSlot && (n = n.assignedSlot);
                          const r = n.closest(e);
                          return r || n.getRootNode ? r || t(n.getRootNode().host) : null;
                      })(t);
                  })(u, l)
                : l.closest(u))
        )
            return void (t.allowClick = !0);
        if (i.swipeHandler && !l.closest(i.swipeHandler)) return;
        ((s.currentX = r.pageX), (s.currentY = r.pageY));
        const f = s.currentX,
            h = s.currentY;
        if (!Am(t, r, f)) return;
        (Object.assign(o, {
            isTouched: !0,
            isMoved: !1,
            allowTouchCallbacks: !0,
            isScrolling: void 0,
            startMoving: void 0
        }),
            (s.startX = f),
            (s.startY = h),
            (o.touchStartTime = Xh()),
            (t.allowClick = !0),
            t.updateSize(),
            (t.swipeDirection = void 0),
            i.threshold > 0 && (o.allowThresholdMove = !1));
        let m = !0;
        (l.matches(o.focusableElements) && ((m = !1), 'SELECT' === l.nodeName && (o.isTouched = !1)),
            n.activeElement &&
                n.activeElement.matches(o.focusableElements) &&
                n.activeElement !== l &&
                ('mouse' === r.pointerType || ('mouse' !== r.pointerType && !l.matches(o.focusableElements))) &&
                n.activeElement.blur());
        const g = m && t.allowTouchMove && i.touchStartPreventDefault;
        ((!i.touchStartForcePreventDefault && !g) || l.isContentEditable || r.preventDefault(),
            i.freeMode && i.freeMode.enabled && t.freeMode && t.animating && !i.cssMode && t.freeMode.onTouchStart(),
            t.emit('touchStart', r));
    }
    function Im(e) {
        const t = Wh(),
            n = this,
            r = n.touchEventsData,
            { params: o, touches: i, rtlTranslate: s, enabled: a } = n;
        if (!a) return;
        if (!o.simulateTouch && 'mouse' === e.pointerType) return;
        let l,
            c = e;
        if ((c.originalEvent && (c = c.originalEvent), 'pointermove' === c.type)) {
            if (null !== r.touchId) return;
            if (c.pointerId !== r.pointerId) return;
        }
        if ('touchmove' === c.type) {
            if (((l = [...c.changedTouches].find(e => e.identifier === r.touchId)), !l || l.identifier !== r.touchId))
                return;
        } else l = c;
        if (!r.isTouched) return void (r.startMoving && r.isScrolling && n.emit('touchMoveOpposite', c));
        const d = l.pageX,
            u = l.pageY;
        if (c.preventedByNestedSwiper) return ((i.startX = d), void (i.startY = u));
        if (!n.allowTouchMove)
            return (
                c.target.matches(r.focusableElements) || (n.allowClick = !1),
                void (
                    r.isTouched &&
                    (Object.assign(i, { startX: d, startY: u, currentX: d, currentY: u }), (r.touchStartTime = Xh()))
                )
            );
        if (o.touchReleaseOnEdges && !o.loop)
            if (n.isVertical()) {
                if (
                    (u < i.startY && n.translate <= n.maxTranslate()) ||
                    (u > i.startY && n.translate >= n.minTranslate())
                )
                    return ((r.isTouched = !1), void (r.isMoved = !1));
            } else {
                if (
                    s &&
                    ((d > i.startX && -n.translate <= n.maxTranslate()) ||
                        (d < i.startX && -n.translate >= n.minTranslate()))
                )
                    return;
                if (
                    !s &&
                    ((d < i.startX && n.translate <= n.maxTranslate()) ||
                        (d > i.startX && n.translate >= n.minTranslate()))
                )
                    return;
            }
        if (
            (t.activeElement &&
                t.activeElement.matches(r.focusableElements) &&
                t.activeElement !== c.target &&
                'mouse' !== c.pointerType &&
                t.activeElement.blur(),
            t.activeElement && c.target === t.activeElement && c.target.matches(r.focusableElements))
        )
            return ((r.isMoved = !0), void (n.allowClick = !1));
        (r.allowTouchCallbacks && n.emit('touchMove', c),
            (i.previousX = i.currentX),
            (i.previousY = i.currentY),
            (i.currentX = d),
            (i.currentY = u));
        const p = i.currentX - i.startX,
            f = i.currentY - i.startY;
        if (n.params.threshold && Math.sqrt(p ** 2 + f ** 2) < n.params.threshold) return;
        if (void 0 === r.isScrolling) {
            let e;
            (n.isHorizontal() && i.currentY === i.startY) || (n.isVertical() && i.currentX === i.startX)
                ? (r.isScrolling = !1)
                : p * p + f * f >= 25 &&
                  ((e = (180 * Math.atan2(Math.abs(f), Math.abs(p))) / Math.PI),
                  (r.isScrolling = n.isHorizontal() ? e > o.touchAngle : 90 - e > o.touchAngle));
        }
        if (
            (r.isScrolling && n.emit('touchMoveOpposite', c),
            void 0 === r.startMoving && ((i.currentX === i.startX && i.currentY === i.startY) || (r.startMoving = !0)),
            r.isScrolling || ('touchmove' === c.type && r.preventTouchMoveFromPointerMove))
        )
            return void (r.isTouched = !1);
        if (!r.startMoving) return;
        ((n.allowClick = !1),
            !o.cssMode && c.cancelable && c.preventDefault(),
            o.touchMoveStopPropagation && !o.nested && c.stopPropagation());
        let h = n.isHorizontal() ? p : f,
            m = n.isHorizontal() ? i.currentX - i.previousX : i.currentY - i.previousY;
        (o.oneWayMovement && ((h = Math.abs(h) * (s ? 1 : -1)), (m = Math.abs(m) * (s ? 1 : -1))),
            (i.diff = h),
            (h *= o.touchRatio),
            s && ((h = -h), (m = -m)));
        const g = n.touchesDirection;
        ((n.swipeDirection = h > 0 ? 'prev' : 'next'), (n.touchesDirection = m > 0 ? 'prev' : 'next'));
        const v = n.params.loop && !o.cssMode,
            y =
                ('next' === n.touchesDirection && n.allowSlideNext) ||
                ('prev' === n.touchesDirection && n.allowSlidePrev);
        if (!r.isMoved) {
            if (
                (v && y && n.loopFix({ direction: n.swipeDirection }),
                (r.startTranslate = n.getTranslate()),
                n.setTransition(0),
                n.animating)
            ) {
                const e = new window.CustomEvent('transitionend', {
                    bubbles: !0,
                    cancelable: !0,
                    detail: { bySwiperTouchMove: !0 }
                });
                n.wrapperEl.dispatchEvent(e);
            }
            ((r.allowMomentumBounce = !1),
                !o.grabCursor || (!0 !== n.allowSlideNext && !0 !== n.allowSlidePrev) || n.setGrabCursor(!0),
                n.emit('sliderFirstMove', c));
        }
        if (
            (new Date().getTime(),
            !1 !== o._loopSwapReset &&
                r.isMoved &&
                r.allowThresholdMove &&
                g !== n.touchesDirection &&
                v &&
                y &&
                Math.abs(h) >= 1)
        )
            return (
                Object.assign(i, {
                    startX: d,
                    startY: u,
                    currentX: d,
                    currentY: u,
                    startTranslate: r.currentTranslate
                }),
                (r.loopSwapReset = !0),
                void (r.startTranslate = r.currentTranslate)
            );
        (n.emit('sliderMove', c), (r.isMoved = !0), (r.currentTranslate = h + r.startTranslate));
        let b = !0,
            w = o.resistanceRatio;
        if (
            (o.touchReleaseOnEdges && (w = 0),
            h > 0
                ? (v &&
                      y &&
                      r.allowThresholdMove &&
                      r.currentTranslate >
                          (o.centeredSlides
                              ? n.minTranslate() -
                                n.slidesSizesGrid[n.activeIndex + 1] -
                                ('auto' !== o.slidesPerView && n.slides.length - o.slidesPerView >= 2
                                    ? n.slidesSizesGrid[n.activeIndex + 1] + n.params.spaceBetween
                                    : 0) -
                                n.params.spaceBetween
                              : n.minTranslate()) &&
                      n.loopFix({ direction: 'prev', setTranslate: !0, activeSlideIndex: 0 }),
                  r.currentTranslate > n.minTranslate() &&
                      ((b = !1),
                      o.resistance &&
                          (r.currentTranslate =
                              n.minTranslate() - 1 + (-n.minTranslate() + r.startTranslate + h) ** w)))
                : h < 0 &&
                  (v &&
                      y &&
                      r.allowThresholdMove &&
                      r.currentTranslate <
                          (o.centeredSlides
                              ? n.maxTranslate() +
                                n.slidesSizesGrid[n.slidesSizesGrid.length - 1] +
                                n.params.spaceBetween +
                                ('auto' !== o.slidesPerView && n.slides.length - o.slidesPerView >= 2
                                    ? n.slidesSizesGrid[n.slidesSizesGrid.length - 1] + n.params.spaceBetween
                                    : 0)
                              : n.maxTranslate()) &&
                      n.loopFix({
                          direction: 'next',
                          setTranslate: !0,
                          activeSlideIndex:
                              n.slides.length -
                              ('auto' === o.slidesPerView
                                  ? n.slidesPerViewDynamic()
                                  : Math.ceil(parseFloat(o.slidesPerView, 10)))
                      }),
                  r.currentTranslate < n.maxTranslate() &&
                      ((b = !1),
                      o.resistance &&
                          (r.currentTranslate =
                              n.maxTranslate() + 1 - (n.maxTranslate() - r.startTranslate - h) ** w))),
            b && (c.preventedByNestedSwiper = !0),
            !n.allowSlideNext &&
                'next' === n.swipeDirection &&
                r.currentTranslate < r.startTranslate &&
                (r.currentTranslate = r.startTranslate),
            !n.allowSlidePrev &&
                'prev' === n.swipeDirection &&
                r.currentTranslate > r.startTranslate &&
                (r.currentTranslate = r.startTranslate),
            n.allowSlidePrev || n.allowSlideNext || (r.currentTranslate = r.startTranslate),
            o.threshold > 0)
        ) {
            if (!(Math.abs(h) > o.threshold || r.allowThresholdMove))
                return void (r.currentTranslate = r.startTranslate);
            if (!r.allowThresholdMove)
                return (
                    (r.allowThresholdMove = !0),
                    (i.startX = i.currentX),
                    (i.startY = i.currentY),
                    (r.currentTranslate = r.startTranslate),
                    void (i.diff = n.isHorizontal() ? i.currentX - i.startX : i.currentY - i.startY)
                );
        }
        o.followFinger &&
            !o.cssMode &&
            (((o.freeMode && o.freeMode.enabled && n.freeMode) || o.watchSlidesProgress) &&
                (n.updateActiveIndex(), n.updateSlidesClasses()),
            o.freeMode && o.freeMode.enabled && n.freeMode && n.freeMode.onTouchMove(),
            n.updateProgress(r.currentTranslate),
            n.setTranslate(r.currentTranslate));
    }
    function Mm(e) {
        const t = this,
            n = t.touchEventsData;
        let r,
            o = e;
        if ((o.originalEvent && (o = o.originalEvent), 'touchend' === o.type || 'touchcancel' === o.type)) {
            if (((r = [...o.changedTouches].find(e => e.identifier === n.touchId)), !r || r.identifier !== n.touchId))
                return;
        } else {
            if (null !== n.touchId) return;
            if (o.pointerId !== n.pointerId) return;
            r = o;
        }
        if (
            ['pointercancel', 'pointerout', 'pointerleave', 'contextmenu'].includes(o.type) &&
            (!['pointercancel', 'contextmenu'].includes(o.type) || (!t.browser.isSafari && !t.browser.isWebView))
        )
            return;
        ((n.pointerId = null), (n.touchId = null));
        const { params: i, touches: s, rtlTranslate: a, slidesGrid: l, enabled: c } = t;
        if (!c) return;
        if (!i.simulateTouch && 'mouse' === o.pointerType) return;
        if ((n.allowTouchCallbacks && t.emit('touchEnd', o), (n.allowTouchCallbacks = !1), !n.isTouched))
            return (n.isMoved && i.grabCursor && t.setGrabCursor(!1), (n.isMoved = !1), void (n.startMoving = !1));
        i.grabCursor &&
            n.isMoved &&
            n.isTouched &&
            (!0 === t.allowSlideNext || !0 === t.allowSlidePrev) &&
            t.setGrabCursor(!1);
        const d = Xh(),
            u = d - n.touchStartTime;
        if (t.allowClick) {
            const e = o.path || (o.composedPath && o.composedPath());
            (t.updateClickedSlide((e && e[0]) || o.target, e),
                t.emit('tap click', o),
                u < 300 && d - n.lastClickTime < 300 && t.emit('doubleTap doubleClick', o));
        }
        if (
            ((n.lastClickTime = Xh()),
            Kh(() => {
                t.destroyed || (t.allowClick = !0);
            }),
            !n.isTouched ||
                !n.isMoved ||
                !t.swipeDirection ||
                (0 === s.diff && !n.loopSwapReset) ||
                (n.currentTranslate === n.startTranslate && !n.loopSwapReset))
        )
            return ((n.isTouched = !1), (n.isMoved = !1), void (n.startMoving = !1));
        let p;
        if (
            ((n.isTouched = !1),
            (n.isMoved = !1),
            (n.startMoving = !1),
            (p = i.followFinger ? (a ? t.translate : -t.translate) : -n.currentTranslate),
            i.cssMode)
        )
            return;
        if (i.freeMode && i.freeMode.enabled) return void t.freeMode.onTouchEnd({ currentPos: p });
        const f = p >= -t.maxTranslate() && !t.params.loop;
        let h = 0,
            m = t.slidesSizesGrid[0];
        for (let e = 0; e < l.length; e += e < i.slidesPerGroupSkip ? 1 : i.slidesPerGroup) {
            const t = e < i.slidesPerGroupSkip - 1 ? 1 : i.slidesPerGroup;
            void 0 !== l[e + t]
                ? (f || (p >= l[e] && p < l[e + t])) && ((h = e), (m = l[e + t] - l[e]))
                : (f || p >= l[e]) && ((h = e), (m = l[l.length - 1] - l[l.length - 2]));
        }
        let g = null,
            v = null;
        i.rewind &&
            (t.isBeginning
                ? (v = i.virtual && i.virtual.enabled && t.virtual ? t.virtual.slides.length - 1 : t.slides.length - 1)
                : t.isEnd && (g = 0));
        const y = (p - l[h]) / m,
            b = h < i.slidesPerGroupSkip - 1 ? 1 : i.slidesPerGroup;
        if (u > i.longSwipesMs) {
            if (!i.longSwipes) return void t.slideTo(t.activeIndex);
            ('next' === t.swipeDirection &&
                (y >= i.longSwipesRatio ? t.slideTo(i.rewind && t.isEnd ? g : h + b) : t.slideTo(h)),
                'prev' === t.swipeDirection &&
                    (y > 1 - i.longSwipesRatio
                        ? t.slideTo(h + b)
                        : null !== v && y < 0 && Math.abs(y) > i.longSwipesRatio
                          ? t.slideTo(v)
                          : t.slideTo(h)));
        } else {
            if (!i.shortSwipes) return void t.slideTo(t.activeIndex);
            !t.navigation || (o.target !== t.navigation.nextEl && o.target !== t.navigation.prevEl)
                ? ('next' === t.swipeDirection && t.slideTo(null !== g ? g : h + b),
                  'prev' === t.swipeDirection && t.slideTo(null !== v ? v : h))
                : o.target === t.navigation.nextEl
                  ? t.slideTo(h + b)
                  : t.slideTo(h);
        }
    }
    function Pm() {
        const e = this,
            { params: t, el: n } = e;
        if (n && 0 === n.offsetWidth) return;
        t.breakpoints && e.setBreakpoint();
        const { allowSlideNext: r, allowSlidePrev: o, snapGrid: i } = e,
            s = e.virtual && e.params.virtual.enabled;
        ((e.allowSlideNext = !0), (e.allowSlidePrev = !0), e.updateSize(), e.updateSlides(), e.updateSlidesClasses());
        const a = s && t.loop;
        (!('auto' === t.slidesPerView || t.slidesPerView > 1) ||
        !e.isEnd ||
        e.isBeginning ||
        e.params.centeredSlides ||
        a
            ? e.params.loop && !s
                ? e.slideToLoop(e.realIndex, 0, !1, !0)
                : e.slideTo(e.activeIndex, 0, !1, !0)
            : e.slideTo(e.slides.length - 1, 0, !1, !0),
            e.autoplay &&
                e.autoplay.running &&
                e.autoplay.paused &&
                (clearTimeout(e.autoplay.resizeTimeout),
                (e.autoplay.resizeTimeout = setTimeout(() => {
                    e.autoplay && e.autoplay.running && e.autoplay.paused && e.autoplay.resume();
                }, 500))),
            (e.allowSlidePrev = o),
            (e.allowSlideNext = r),
            e.params.watchOverflow && i !== e.snapGrid && e.checkOverflow());
    }
    function Nm(e) {
        const t = this;
        t.enabled &&
            (t.allowClick ||
                (t.params.preventClicks && e.preventDefault(),
                t.params.preventClicksPropagation &&
                    t.animating &&
                    (e.stopPropagation(), e.stopImmediatePropagation())));
    }
    function Lm() {
        const e = this,
            { wrapperEl: t, rtlTranslate: n, enabled: r } = e;
        if (!r) return;
        let o;
        ((e.previousTranslate = e.translate),
            e.isHorizontal() ? (e.translate = -t.scrollLeft) : (e.translate = -t.scrollTop),
            0 === e.translate && (e.translate = 0),
            e.updateActiveIndex(),
            e.updateSlidesClasses());
        const i = e.maxTranslate() - e.minTranslate();
        ((o = 0 === i ? 0 : (e.translate - e.minTranslate()) / i),
            o !== e.progress && e.updateProgress(n ? -e.translate : e.translate),
            e.emit('setTranslate', e.translate, !1));
    }
    function Rm(e) {
        const t = this;
        (ym(t, e.target),
            t.params.cssMode || ('auto' !== t.params.slidesPerView && !t.params.autoHeight) || t.update());
    }
    function $m() {
        const e = this;
        e.documentTouchHandlerProceeded ||
            ((e.documentTouchHandlerProceeded = !0), e.params.touchReleaseOnEdges && (e.el.style.touchAction = 'auto'));
    }
    const Bm = (e, t) => {
        const n = Wh(),
            { params: r, el: o, wrapperEl: i, device: s } = e,
            a = !!r.nested,
            l = 'on' === t ? 'addEventListener' : 'removeEventListener',
            c = t;
        o &&
            'string' != typeof o &&
            (n[l]('touchstart', e.onDocumentTouchStart, { passive: !1, capture: a }),
            o[l]('touchstart', e.onTouchStart, { passive: !1 }),
            o[l]('pointerdown', e.onTouchStart, { passive: !1 }),
            n[l]('touchmove', e.onTouchMove, { passive: !1, capture: a }),
            n[l]('pointermove', e.onTouchMove, { passive: !1, capture: a }),
            n[l]('touchend', e.onTouchEnd, { passive: !0 }),
            n[l]('pointerup', e.onTouchEnd, { passive: !0 }),
            n[l]('pointercancel', e.onTouchEnd, { passive: !0 }),
            n[l]('touchcancel', e.onTouchEnd, { passive: !0 }),
            n[l]('pointerout', e.onTouchEnd, { passive: !0 }),
            n[l]('pointerleave', e.onTouchEnd, { passive: !0 }),
            n[l]('contextmenu', e.onTouchEnd, { passive: !0 }),
            (r.preventClicks || r.preventClicksPropagation) && o[l]('click', e.onClick, !0),
            r.cssMode && i[l]('scroll', e.onScroll),
            r.updateOnWindowResize
                ? e[c](s.ios || s.android ? 'resize orientationchange observerUpdate' : 'resize observerUpdate', Pm, !0)
                : e[c]('observerUpdate', Pm, !0),
            o[l]('load', e.onLoad, { capture: !0 }));
    };
    var Fm = {
        attachEvents: function () {
            const e = this,
                { params: t } = e;
            ((e.onTouchStart = Om.bind(e)),
                (e.onTouchMove = Im.bind(e)),
                (e.onTouchEnd = Mm.bind(e)),
                (e.onDocumentTouchStart = $m.bind(e)),
                t.cssMode && (e.onScroll = Lm.bind(e)),
                (e.onClick = Nm.bind(e)),
                (e.onLoad = Rm.bind(e)),
                Bm(e, 'on'));
        },
        detachEvents: function () {
            Bm(this, 'off');
        }
    };
    const Dm = (e, t) => e.grid && t.grid && t.grid.rows > 1;
    var jm = {
            setBreakpoint: function () {
                const e = this,
                    { realIndex: t, initialized: n, params: r, el: o } = e,
                    i = r.breakpoints;
                if (!i || (i && 0 === Object.keys(i).length)) return;
                const s = Wh(),
                    a = 'window' !== r.breakpointsBase && r.breakpointsBase ? 'container' : r.breakpointsBase,
                    l =
                        ['window', 'container'].includes(r.breakpointsBase) || !r.breakpointsBase
                            ? e.el
                            : s.querySelector(r.breakpointsBase),
                    c = e.getBreakpoint(i, a, l);
                if (!c || e.currentBreakpoint === c) return;
                const d = (c in i ? i[c] : void 0) || e.originalParams,
                    u = Dm(e, r),
                    p = Dm(e, d),
                    f = e.params.grabCursor,
                    h = d.grabCursor,
                    m = r.enabled;
                (u && !p
                    ? (o.classList.remove(`${r.containerModifierClass}grid`, `${r.containerModifierClass}grid-column`),
                      e.emitContainerClasses())
                    : !u &&
                      p &&
                      (o.classList.add(`${r.containerModifierClass}grid`),
                      ((d.grid.fill && 'column' === d.grid.fill) || (!d.grid.fill && 'column' === r.grid.fill)) &&
                          o.classList.add(`${r.containerModifierClass}grid-column`),
                      e.emitContainerClasses()),
                    f && !h ? e.unsetGrabCursor() : !f && h && e.setGrabCursor(),
                    ['navigation', 'pagination', 'scrollbar'].forEach(t => {
                        if (void 0 === d[t]) return;
                        const n = r[t] && r[t].enabled,
                            o = d[t] && d[t].enabled;
                        (n && !o && e[t].disable(), !n && o && e[t].enable());
                    }));
                const g = d.direction && d.direction !== r.direction,
                    v = r.loop && (d.slidesPerView !== r.slidesPerView || g),
                    y = r.loop;
                (g && n && e.changeDirection(), Zh(e.params, d));
                const b = e.params.enabled,
                    w = e.params.loop;
                (Object.assign(e, {
                    allowTouchMove: e.params.allowTouchMove,
                    allowSlideNext: e.params.allowSlideNext,
                    allowSlidePrev: e.params.allowSlidePrev
                }),
                    m && !b ? e.disable() : !m && b && e.enable(),
                    (e.currentBreakpoint = c),
                    e.emit('_beforeBreakpoint', d),
                    n &&
                        (v
                            ? (e.loopDestroy(), e.loopCreate(t), e.updateSlides())
                            : !y && w
                              ? (e.loopCreate(t), e.updateSlides())
                              : y && !w && e.loopDestroy()),
                    e.emit('breakpoint', d));
            },
            getBreakpoint: function (e, t = 'window', n) {
                if (!e || ('container' === t && !n)) return;
                let r = !1;
                const o = Yh(),
                    i = 'window' === t ? o.innerHeight : n.clientHeight,
                    s = Object.keys(e).map(e => {
                        if ('string' == typeof e && 0 === e.indexOf('@')) {
                            const t = parseFloat(e.substr(1));
                            return { value: i * t, point: e };
                        }
                        return { value: e, point: e };
                    });
                s.sort((e, t) => parseInt(e.value, 10) - parseInt(t.value, 10));
                for (let e = 0; e < s.length; e += 1) {
                    const { point: i, value: a } = s[e];
                    'window' === t
                        ? o.matchMedia(`(min-width: ${a}px)`).matches && (r = i)
                        : a <= n.clientWidth && (r = i);
                }
                return r || 'max';
            }
        },
        Vm = {
            addClasses: function () {
                const e = this,
                    { classNames: t, params: n, rtl: r, el: o, device: i } = e,
                    s = (function (e, t) {
                        const n = [];
                        return (
                            e.forEach(e => {
                                'object' == typeof e
                                    ? Object.keys(e).forEach(r => {
                                          e[r] && n.push(t + r);
                                      })
                                    : 'string' == typeof e && n.push(t + e);
                            }),
                            n
                        );
                    })(
                        [
                            'initialized',
                            n.direction,
                            { 'free-mode': e.params.freeMode && n.freeMode.enabled },
                            { autoheight: n.autoHeight },
                            { rtl: r },
                            { grid: n.grid && n.grid.rows > 1 },
                            { 'grid-column': n.grid && n.grid.rows > 1 && 'column' === n.grid.fill },
                            { android: i.android },
                            { ios: i.ios },
                            { 'css-mode': n.cssMode },
                            { centered: n.cssMode && n.centeredSlides },
                            { 'watch-progress': n.watchSlidesProgress }
                        ],
                        n.containerModifierClass
                    );
                (t.push(...s), o.classList.add(...t), e.emitContainerClasses());
            },
            removeClasses: function () {
                const { el: e, classNames: t } = this;
                e && 'string' != typeof e && (e.classList.remove(...t), this.emitContainerClasses());
            }
        },
        zm = {
            init: !0,
            direction: 'horizontal',
            oneWayMovement: !1,
            swiperElementNodeName: 'SWIPER-CONTAINER',
            touchEventsTarget: 'wrapper',
            initialSlide: 0,
            speed: 300,
            cssMode: !1,
            updateOnWindowResize: !0,
            resizeObserver: !0,
            nested: !1,
            createElements: !1,
            eventsPrefix: 'swiper',
            enabled: !0,
            focusableElements: 'input, select, option, textarea, button, video, label',
            width: null,
            height: null,
            preventInteractionOnTransition: !1,
            userAgent: null,
            url: null,
            edgeSwipeDetection: !1,
            edgeSwipeThreshold: 20,
            autoHeight: !1,
            setWrapperSize: !1,
            virtualTranslate: !1,
            effect: 'slide',
            breakpoints: void 0,
            breakpointsBase: 'window',
            spaceBetween: 0,
            slidesPerView: 1,
            slidesPerGroup: 1,
            slidesPerGroupSkip: 0,
            slidesPerGroupAuto: !1,
            centeredSlides: !1,
            centeredSlidesBounds: !1,
            slidesOffsetBefore: 0,
            slidesOffsetAfter: 0,
            normalizeSlideIndex: !0,
            centerInsufficientSlides: !1,
            watchOverflow: !0,
            roundLengths: !1,
            touchRatio: 1,
            touchAngle: 45,
            simulateTouch: !0,
            shortSwipes: !0,
            longSwipes: !0,
            longSwipesRatio: 0.5,
            longSwipesMs: 300,
            followFinger: !0,
            allowTouchMove: !0,
            threshold: 5,
            touchMoveStopPropagation: !1,
            touchStartPreventDefault: !0,
            touchStartForcePreventDefault: !1,
            touchReleaseOnEdges: !1,
            uniqueNavElements: !0,
            resistance: !0,
            resistanceRatio: 0.85,
            watchSlidesProgress: !1,
            grabCursor: !1,
            preventClicks: !0,
            preventClicksPropagation: !0,
            slideToClickedSlide: !1,
            loop: !1,
            loopAddBlankSlides: !0,
            loopAdditionalSlides: 0,
            loopPreventsSliding: !0,
            rewind: !1,
            allowSlidePrev: !0,
            allowSlideNext: !0,
            swipeHandler: null,
            noSwiping: !0,
            noSwipingClass: 'swiper-no-swiping',
            noSwipingSelector: null,
            passiveListeners: !0,
            maxBackfaceHiddenSlides: 10,
            containerModifierClass: 'swiper-',
            slideClass: 'swiper-slide',
            slideBlankClass: 'swiper-slide-blank',
            slideActiveClass: 'swiper-slide-active',
            slideVisibleClass: 'swiper-slide-visible',
            slideFullyVisibleClass: 'swiper-slide-fully-visible',
            slideNextClass: 'swiper-slide-next',
            slidePrevClass: 'swiper-slide-prev',
            wrapperClass: 'swiper-wrapper',
            lazyPreloaderClass: 'swiper-lazy-preloader',
            lazyPreloadPrevNext: 0,
            runCallbacksOnInit: !0,
            _emitClasses: !1
        };
    function Hm(e, t) {
        return function (n = {}) {
            const r = Object.keys(n)[0],
                o = n[r];
            'object' == typeof o && null !== o
                ? (!0 === e[r] && (e[r] = { enabled: !0 }),
                  'navigation' === r && e[r] && e[r].enabled && !e[r].prevEl && !e[r].nextEl && (e[r].auto = !0),
                  ['pagination', 'scrollbar'].indexOf(r) >= 0 && e[r] && e[r].enabled && !e[r].el && (e[r].auto = !0),
                  r in e && 'enabled' in o
                      ? ('object' != typeof e[r] || 'enabled' in e[r] || (e[r].enabled = !0),
                        e[r] || (e[r] = { enabled: !1 }),
                        Zh(t, n))
                      : Zh(t, n))
                : Zh(t, n);
        };
    }
    const Um = {
            eventsEmitter: mm,
            update: Sm,
            translate: xm,
            transition: Tm,
            slide: Cm,
            loop: km,
            grabCursor: Em,
            events: Fm,
            breakpoints: jm,
            checkOverflow: {
                checkOverflow: function () {
                    const e = this,
                        { isLocked: t, params: n } = e,
                        { slidesOffsetBefore: r } = n;
                    if (r) {
                        const t = e.slides.length - 1,
                            n = e.slidesGrid[t] + e.slidesSizesGrid[t] + 2 * r;
                        e.isLocked = e.size > n;
                    } else e.isLocked = 1 === e.snapGrid.length;
                    (!0 === n.allowSlideNext && (e.allowSlideNext = !e.isLocked),
                        !0 === n.allowSlidePrev && (e.allowSlidePrev = !e.isLocked),
                        t && t !== e.isLocked && (e.isEnd = !1),
                        t !== e.isLocked && e.emit(e.isLocked ? 'lock' : 'unlock'));
                }
            },
            classes: Vm
        },
        qm = {};
    class Wm {
        constructor(...e) {
            let t, n;
            (1 === e.length && e[0].constructor && 'Object' === Object.prototype.toString.call(e[0]).slice(8, -1)
                ? (n = e[0])
                : ([t, n] = e),
                n || (n = {}),
                (n = Zh({}, n)),
                t && !n.el && (n.el = t));
            const r = Wh();
            if (n.el && 'string' == typeof n.el && r.querySelectorAll(n.el).length > 1) {
                const e = [];
                return (
                    r.querySelectorAll(n.el).forEach(t => {
                        const r = Zh({}, n, { el: t });
                        e.push(new Wm(r));
                    }),
                    e
                );
            }
            const o = this;
            ((o.__swiper__ = !0),
                (o.support = pm()),
                (o.device = fm({ userAgent: n.userAgent })),
                (o.browser = hm()),
                (o.eventsListeners = {}),
                (o.eventsAnyListeners = []),
                (o.modules = [...o.__modules__]),
                n.modules && Array.isArray(n.modules) && o.modules.push(...n.modules));
            const i = {};
            o.modules.forEach(e => {
                e({
                    params: n,
                    swiper: o,
                    extendParams: Hm(n, i),
                    on: o.on.bind(o),
                    once: o.once.bind(o),
                    off: o.off.bind(o),
                    emit: o.emit.bind(o)
                });
            });
            const s = Zh({}, zm, i);
            return (
                (o.params = Zh({}, s, qm, n)),
                (o.originalParams = Zh({}, o.params)),
                (o.passedParams = Zh({}, n)),
                o.params &&
                    o.params.on &&
                    Object.keys(o.params.on).forEach(e => {
                        o.on(e, o.params.on[e]);
                    }),
                o.params && o.params.onAny && o.onAny(o.params.onAny),
                Object.assign(o, {
                    enabled: o.params.enabled,
                    el: t,
                    classNames: [],
                    slides: [],
                    slidesGrid: [],
                    snapGrid: [],
                    slidesSizesGrid: [],
                    isHorizontal: () => 'horizontal' === o.params.direction,
                    isVertical: () => 'vertical' === o.params.direction,
                    activeIndex: 0,
                    realIndex: 0,
                    isBeginning: !0,
                    isEnd: !1,
                    translate: 0,
                    previousTranslate: 0,
                    progress: 0,
                    velocity: 0,
                    animating: !1,
                    cssOverflowAdjustment() {
                        return Math.trunc(this.translate / 2 ** 23) * 2 ** 23;
                    },
                    allowSlideNext: o.params.allowSlideNext,
                    allowSlidePrev: o.params.allowSlidePrev,
                    touchEventsData: {
                        isTouched: void 0,
                        isMoved: void 0,
                        allowTouchCallbacks: void 0,
                        touchStartTime: void 0,
                        isScrolling: void 0,
                        currentTranslate: void 0,
                        startTranslate: void 0,
                        allowThresholdMove: void 0,
                        focusableElements: o.params.focusableElements,
                        lastClickTime: 0,
                        clickTimeout: void 0,
                        velocities: [],
                        allowMomentumBounce: void 0,
                        startMoving: void 0,
                        pointerId: null,
                        touchId: null
                    },
                    allowClick: !0,
                    allowTouchMove: o.params.allowTouchMove,
                    touches: { startX: 0, startY: 0, currentX: 0, currentY: 0, diff: 0 },
                    imagesToLoad: [],
                    imagesLoaded: 0
                }),
                o.emit('_swiper'),
                o.params.init && o.init(),
                o
            );
        }
        getDirectionLabel(e) {
            return this.isHorizontal()
                ? e
                : {
                      width: 'height',
                      'margin-top': 'margin-left',
                      'margin-bottom ': 'margin-right',
                      'margin-left': 'margin-top',
                      'margin-right': 'margin-bottom',
                      'padding-left': 'padding-top',
                      'padding-right': 'padding-bottom',
                      marginRight: 'marginBottom'
                  }[e];
        }
        getSlideIndex(e) {
            const { slidesEl: t, params: n } = this,
                r = sm(nm(t, `.${n.slideClass}, swiper-slide`)[0]);
            return sm(e) - r;
        }
        getSlideIndexByData(e) {
            return this.getSlideIndex(this.slides.find(t => 1 * t.getAttribute('data-swiper-slide-index') === e));
        }
        getSlideIndexWhenGrid(e) {
            return (
                this.grid &&
                    this.params.grid &&
                    this.params.grid.rows > 1 &&
                    ('column' === this.params.grid.fill
                        ? (e = Math.floor(e / this.params.grid.rows))
                        : 'row' === this.params.grid.fill &&
                          (e %= Math.ceil(this.slides.length / this.params.grid.rows))),
                e
            );
        }
        recalcSlides() {
            const { slidesEl: e, params: t } = this;
            this.slides = nm(e, `.${t.slideClass}, swiper-slide`);
        }
        enable() {
            const e = this;
            e.enabled || ((e.enabled = !0), e.params.grabCursor && e.setGrabCursor(), e.emit('enable'));
        }
        disable() {
            const e = this;
            e.enabled && ((e.enabled = !1), e.params.grabCursor && e.unsetGrabCursor(), e.emit('disable'));
        }
        setProgress(e, t) {
            const n = this;
            e = Math.min(Math.max(e, 0), 1);
            const r = n.minTranslate(),
                o = (n.maxTranslate() - r) * e + r;
            (n.translateTo(o, void 0 === t ? 0 : t), n.updateActiveIndex(), n.updateSlidesClasses());
        }
        emitContainerClasses() {
            const e = this;
            if (!e.params._emitClasses || !e.el) return;
            const t = e.el.className
                .split(' ')
                .filter(t => 0 === t.indexOf('swiper') || 0 === t.indexOf(e.params.containerModifierClass));
            e.emit('_containerClasses', t.join(' '));
        }
        getSlideClasses(e) {
            const t = this;
            return t.destroyed
                ? ''
                : e.className
                      .split(' ')
                      .filter(e => 0 === e.indexOf('swiper-slide') || 0 === e.indexOf(t.params.slideClass))
                      .join(' ');
        }
        emitSlidesClasses() {
            const e = this;
            if (!e.params._emitClasses || !e.el) return;
            const t = [];
            (e.slides.forEach(n => {
                const r = e.getSlideClasses(n);
                (t.push({ slideEl: n, classNames: r }), e.emit('_slideClass', n, r));
            }),
                e.emit('_slideClasses', t));
        }
        slidesPerViewDynamic(e = 'current', t = !1) {
            const { params: n, slides: r, slidesGrid: o, slidesSizesGrid: i, size: s, activeIndex: a } = this;
            let l = 1;
            if ('number' == typeof n.slidesPerView) return n.slidesPerView;
            if (n.centeredSlides) {
                let e,
                    t = r[a] ? Math.ceil(r[a].swiperSlideSize) : 0;
                for (let n = a + 1; n < r.length; n += 1)
                    r[n] && !e && ((t += Math.ceil(r[n].swiperSlideSize)), (l += 1), t > s && (e = !0));
                for (let n = a - 1; n >= 0; n -= 1)
                    r[n] && !e && ((t += r[n].swiperSlideSize), (l += 1), t > s && (e = !0));
            } else if ('current' === e)
                for (let e = a + 1; e < r.length; e += 1) (t ? o[e] + i[e] - o[a] < s : o[e] - o[a] < s) && (l += 1);
            else for (let e = a - 1; e >= 0; e -= 1) o[a] - o[e] < s && (l += 1);
            return l;
        }
        update() {
            const e = this;
            if (!e || e.destroyed) return;
            const { snapGrid: t, params: n } = e;
            function r() {
                const t = e.rtlTranslate ? -1 * e.translate : e.translate,
                    n = Math.min(Math.max(t, e.maxTranslate()), e.minTranslate());
                (e.setTranslate(n), e.updateActiveIndex(), e.updateSlidesClasses());
            }
            let o;
            if (
                (n.breakpoints && e.setBreakpoint(),
                [...e.el.querySelectorAll('[loading="lazy"]')].forEach(t => {
                    t.complete && ym(e, t);
                }),
                e.updateSize(),
                e.updateSlides(),
                e.updateProgress(),
                e.updateSlidesClasses(),
                n.freeMode && n.freeMode.enabled && !n.cssMode)
            )
                (r(), n.autoHeight && e.updateAutoHeight());
            else {
                if (('auto' === n.slidesPerView || n.slidesPerView > 1) && e.isEnd && !n.centeredSlides) {
                    const t = e.virtual && n.virtual.enabled ? e.virtual.slides : e.slides;
                    o = e.slideTo(t.length - 1, 0, !1, !0);
                } else o = e.slideTo(e.activeIndex, 0, !1, !0);
                o || r();
            }
            (n.watchOverflow && t !== e.snapGrid && e.checkOverflow(), e.emit('update'));
        }
        changeDirection(e, t = !0) {
            const n = this,
                r = n.params.direction;
            return (
                e || (e = 'horizontal' === r ? 'vertical' : 'horizontal'),
                e === r ||
                    ('horizontal' !== e && 'vertical' !== e) ||
                    (n.el.classList.remove(`${n.params.containerModifierClass}${r}`),
                    n.el.classList.add(`${n.params.containerModifierClass}${e}`),
                    n.emitContainerClasses(),
                    (n.params.direction = e),
                    n.slides.forEach(t => {
                        'vertical' === e ? (t.style.width = '') : (t.style.height = '');
                    }),
                    n.emit('changeDirection'),
                    t && n.update()),
                n
            );
        }
        changeLanguageDirection(e) {
            const t = this;
            (t.rtl && 'rtl' === e) ||
                (!t.rtl && 'ltr' === e) ||
                ((t.rtl = 'rtl' === e),
                (t.rtlTranslate = 'horizontal' === t.params.direction && t.rtl),
                t.rtl
                    ? (t.el.classList.add(`${t.params.containerModifierClass}rtl`), (t.el.dir = 'rtl'))
                    : (t.el.classList.remove(`${t.params.containerModifierClass}rtl`), (t.el.dir = 'ltr')),
                t.update());
        }
        mount(e) {
            const t = this;
            if (t.mounted) return !0;
            let n = e || t.params.el;
            if (('string' == typeof n && (n = document.querySelector(n)), !n)) return !1;
            ((n.swiper = t),
                n.parentNode &&
                    n.parentNode.host &&
                    n.parentNode.host.nodeName === t.params.swiperElementNodeName.toUpperCase() &&
                    (t.isElement = !0));
            const r = () => `.${(t.params.wrapperClass || '').trim().split(' ').join('.')}`;
            let o = n && n.shadowRoot && n.shadowRoot.querySelector ? n.shadowRoot.querySelector(r()) : nm(n, r())[0];
            return (
                !o &&
                    t.params.createElements &&
                    ((o = om('div', t.params.wrapperClass)),
                    n.append(o),
                    nm(n, `.${t.params.slideClass}`).forEach(e => {
                        o.append(e);
                    })),
                Object.assign(t, {
                    el: n,
                    wrapperEl: o,
                    slidesEl: t.isElement && !n.parentNode.host.slideSlots ? n.parentNode.host : o,
                    hostEl: t.isElement ? n.parentNode.host : n,
                    mounted: !0,
                    rtl: 'rtl' === n.dir.toLowerCase() || 'rtl' === im(n, 'direction'),
                    rtlTranslate:
                        'horizontal' === t.params.direction &&
                        ('rtl' === n.dir.toLowerCase() || 'rtl' === im(n, 'direction')),
                    wrongRTL: '-webkit-box' === im(o, 'display')
                }),
                !0
            );
        }
        init(e) {
            const t = this;
            if (t.initialized) return t;
            if (!1 === t.mount(e)) return t;
            (t.emit('beforeInit'),
                t.params.breakpoints && t.setBreakpoint(),
                t.addClasses(),
                t.updateSize(),
                t.updateSlides(),
                t.params.watchOverflow && t.checkOverflow(),
                t.params.grabCursor && t.enabled && t.setGrabCursor(),
                t.params.loop && t.virtual && t.params.virtual.enabled
                    ? t.slideTo(t.params.initialSlide + t.virtual.slidesBefore, 0, t.params.runCallbacksOnInit, !1, !0)
                    : t.slideTo(t.params.initialSlide, 0, t.params.runCallbacksOnInit, !1, !0),
                t.params.loop && t.loopCreate(void 0, !0),
                t.attachEvents());
            const n = [...t.el.querySelectorAll('[loading="lazy"]')];
            return (
                t.isElement && n.push(...t.hostEl.querySelectorAll('[loading="lazy"]')),
                n.forEach(e => {
                    e.complete
                        ? ym(t, e)
                        : e.addEventListener('load', e => {
                              ym(t, e.target);
                          });
                }),
                wm(t),
                (t.initialized = !0),
                wm(t),
                t.emit('init'),
                t.emit('afterInit'),
                t
            );
        }
        destroy(e = !0, t = !0) {
            const n = this,
                { params: r, el: o, wrapperEl: i, slides: s } = n;
            return (
                void 0 === n.params ||
                    n.destroyed ||
                    (n.emit('beforeDestroy'),
                    (n.initialized = !1),
                    n.detachEvents(),
                    r.loop && n.loopDestroy(),
                    t &&
                        (n.removeClasses(),
                        o && 'string' != typeof o && o.removeAttribute('style'),
                        i && i.removeAttribute('style'),
                        s &&
                            s.length &&
                            s.forEach(e => {
                                (e.classList.remove(
                                    r.slideVisibleClass,
                                    r.slideFullyVisibleClass,
                                    r.slideActiveClass,
                                    r.slideNextClass,
                                    r.slidePrevClass
                                ),
                                    e.removeAttribute('style'),
                                    e.removeAttribute('data-swiper-slide-index'));
                            })),
                    n.emit('destroy'),
                    Object.keys(n.eventsListeners).forEach(e => {
                        n.off(e);
                    }),
                    !1 !== e &&
                        (n.el && 'string' != typeof n.el && (n.el.swiper = null),
                        (function (e) {
                            const t = e;
                            Object.keys(t).forEach(e => {
                                try {
                                    t[e] = null;
                                } catch (e) {}
                                try {
                                    delete t[e];
                                } catch (e) {}
                            });
                        })(n)),
                    (n.destroyed = !0)),
                null
            );
        }
        static extendDefaults(e) {
            Zh(qm, e);
        }
        static get extendedDefaults() {
            return qm;
        }
        static get defaults() {
            return zm;
        }
        static installModule(e) {
            Wm.prototype.__modules__ || (Wm.prototype.__modules__ = []);
            const t = Wm.prototype.__modules__;
            'function' == typeof e && t.indexOf(e) < 0 && t.push(e);
        }
        static use(e) {
            return Array.isArray(e) ? (e.forEach(e => Wm.installModule(e)), Wm) : (Wm.installModule(e), Wm);
        }
    }
    (Object.keys(Um).forEach(e => {
        Object.keys(Um[e]).forEach(t => {
            Wm.prototype[t] = Um[e][t];
        });
    }),
        Wm.use([
            function ({ swiper: e, on: t, emit: n }) {
                const r = Yh();
                let o = null,
                    i = null;
                const s = () => {
                        e && !e.destroyed && e.initialized && (n('beforeResize'), n('resize'));
                    },
                    a = () => {
                        e && !e.destroyed && e.initialized && n('orientationchange');
                    };
                (t('init', () => {
                    e.params.resizeObserver && void 0 !== r.ResizeObserver
                        ? e &&
                          !e.destroyed &&
                          e.initialized &&
                          ((o = new ResizeObserver(t => {
                              i = r.requestAnimationFrame(() => {
                                  const { width: n, height: r } = e;
                                  let o = n,
                                      i = r;
                                  (t.forEach(({ contentBoxSize: t, contentRect: n, target: r }) => {
                                      (r && r !== e.el) ||
                                          ((o = n ? n.width : (t[0] || t).inlineSize),
                                          (i = n ? n.height : (t[0] || t).blockSize));
                                  }),
                                      (o === n && i === r) || s());
                              });
                          })),
                          o.observe(e.el))
                        : (r.addEventListener('resize', s), r.addEventListener('orientationchange', a));
                }),
                    t('destroy', () => {
                        (i && r.cancelAnimationFrame(i),
                            o && o.unobserve && e.el && (o.unobserve(e.el), (o = null)),
                            r.removeEventListener('resize', s),
                            r.removeEventListener('orientationchange', a));
                    }));
            },
            function ({ swiper: e, extendParams: t, on: n, emit: r }) {
                const o = [],
                    i = Yh(),
                    s = (t, n = {}) => {
                        const s = new (i.MutationObserver || i.WebkitMutationObserver)(t => {
                            if (e.__preventObserver__) return;
                            if (1 === t.length) return void r('observerUpdate', t[0]);
                            const n = function () {
                                r('observerUpdate', t[0]);
                            };
                            i.requestAnimationFrame ? i.requestAnimationFrame(n) : i.setTimeout(n, 0);
                        });
                        (s.observe(t, {
                            attributes: void 0 === n.attributes || n.attributes,
                            childList: e.isElement || (void 0 === n.childList || n).childList,
                            characterData: void 0 === n.characterData || n.characterData
                        }),
                            o.push(s));
                    };
                (t({ observer: !1, observeParents: !1, observeSlideChildren: !1 }),
                    n('init', () => {
                        if (e.params.observer) {
                            if (e.params.observeParents) {
                                const t = (function (e) {
                                    const t = [];
                                    let n = e.parentElement;
                                    for (; n; ) (t.push(n), (n = n.parentElement));
                                    return t;
                                })(e.hostEl);
                                for (let e = 0; e < t.length; e += 1) s(t[e]);
                            }
                            (s(e.hostEl, { childList: e.params.observeSlideChildren }),
                                s(e.wrapperEl, { attributes: !1 }));
                        }
                    }),
                    n('destroy', () => {
                        (o.forEach(e => {
                            e.disconnect();
                        }),
                            o.splice(0, o.length));
                    }));
            }
        ]));
    const Gm = [
        'eventsPrefix',
        'injectStyles',
        'injectStylesUrls',
        'modules',
        'init',
        '_direction',
        'oneWayMovement',
        'swiperElementNodeName',
        'touchEventsTarget',
        'initialSlide',
        '_speed',
        'cssMode',
        'updateOnWindowResize',
        'resizeObserver',
        'nested',
        'focusableElements',
        '_enabled',
        '_width',
        '_height',
        'preventInteractionOnTransition',
        'userAgent',
        'url',
        '_edgeSwipeDetection',
        '_edgeSwipeThreshold',
        '_freeMode',
        '_autoHeight',
        'setWrapperSize',
        'virtualTranslate',
        '_effect',
        'breakpoints',
        'breakpointsBase',
        '_spaceBetween',
        '_slidesPerView',
        'maxBackfaceHiddenSlides',
        '_grid',
        '_slidesPerGroup',
        '_slidesPerGroupSkip',
        '_slidesPerGroupAuto',
        '_centeredSlides',
        '_centeredSlidesBounds',
        '_slidesOffsetBefore',
        '_slidesOffsetAfter',
        'normalizeSlideIndex',
        '_centerInsufficientSlides',
        '_watchOverflow',
        'roundLengths',
        'touchRatio',
        'touchAngle',
        'simulateTouch',
        '_shortSwipes',
        '_longSwipes',
        'longSwipesRatio',
        'longSwipesMs',
        '_followFinger',
        'allowTouchMove',
        '_threshold',
        'touchMoveStopPropagation',
        'touchStartPreventDefault',
        'touchStartForcePreventDefault',
        'touchReleaseOnEdges',
        'uniqueNavElements',
        '_resistance',
        '_resistanceRatio',
        '_watchSlidesProgress',
        '_grabCursor',
        'preventClicks',
        'preventClicksPropagation',
        '_slideToClickedSlide',
        '_loop',
        'loopAdditionalSlides',
        'loopAddBlankSlides',
        'loopPreventsSliding',
        '_rewind',
        '_allowSlidePrev',
        '_allowSlideNext',
        '_swipeHandler',
        '_noSwiping',
        'noSwipingClass',
        'noSwipingSelector',
        'passiveListeners',
        'containerModifierClass',
        'slideClass',
        'slideActiveClass',
        'slideVisibleClass',
        'slideFullyVisibleClass',
        'slideNextClass',
        'slidePrevClass',
        'slideBlankClass',
        'wrapperClass',
        'lazyPreloaderClass',
        'lazyPreloadPrevNext',
        'runCallbacksOnInit',
        'observer',
        'observeParents',
        'observeSlideChildren',
        'a11y',
        '_autoplay',
        '_controller',
        'coverflowEffect',
        'cubeEffect',
        'fadeEffect',
        'flipEffect',
        'creativeEffect',
        'cardsEffect',
        'hashNavigation',
        'history',
        'keyboard',
        'mousewheel',
        '_navigation',
        '_pagination',
        'parallax',
        '_scrollbar',
        '_thumbs',
        'virtual',
        'zoom',
        'control'
    ];
    function Ym(e) {
        return (
            'object' == typeof e &&
            null !== e &&
            e.constructor &&
            'Object' === Object.prototype.toString.call(e).slice(8, -1) &&
            !e.__swiper__
        );
    }
    function Km(e, t) {
        const n = ['__proto__', 'constructor', 'prototype'];
        Object.keys(t)
            .filter(e => n.indexOf(e) < 0)
            .forEach(n => {
                void 0 === e[n]
                    ? (e[n] = t[n])
                    : Ym(t[n]) && Ym(e[n]) && Object.keys(t[n]).length > 0
                      ? t[n].__swiper__
                          ? (e[n] = t[n])
                          : Km(e[n], t[n])
                      : (e[n] = t[n]);
            });
    }
    function Xm(e = {}) {
        return e.navigation && void 0 === e.navigation.nextEl && void 0 === e.navigation.prevEl;
    }
    function Jm(e = {}) {
        return e.pagination && void 0 === e.pagination.el;
    }
    function Qm(e = {}) {
        return e.scrollbar && void 0 === e.scrollbar.el;
    }
    function Zm(e = '') {
        const t = e
                .split(' ')
                .map(e => e.trim())
                .filter(e => !!e),
            n = [];
        return (
            t.forEach(e => {
                n.indexOf(e) < 0 && n.push(e);
            }),
            n.join(' ')
        );
    }
    function eg(e = '') {
        return e ? (e.includes('swiper-wrapper') ? e : `swiper-wrapper ${e}`) : 'swiper-wrapper';
    }
    function tg(e = {}, t = !0) {
        const n = { on: {} },
            r = {},
            o = {};
        (Km(n, zm), (n._emitClasses = !0), (n.init = !1));
        const i = {},
            s = Gm.map(e => e.replace(/_/, '')),
            a = Object.assign({}, e);
        return (
            Object.keys(a).forEach(a => {
                void 0 !== e[a] &&
                    (s.indexOf(a) >= 0
                        ? Ym(e[a])
                            ? ((n[a] = {}), (o[a] = {}), Km(n[a], e[a]), Km(o[a], e[a]))
                            : ((n[a] = e[a]), (o[a] = e[a]))
                        : 0 === a.search(/on[A-Z]/) && 'function' == typeof e[a]
                          ? t
                              ? (r[`${a[2].toLowerCase()}${a.substr(3)}`] = e[a])
                              : (n.on[`${a[2].toLowerCase()}${a.substr(3)}`] = e[a])
                          : (i[a] = e[a]));
            }),
            ['navigation', 'pagination', 'scrollbar'].forEach(e => {
                (!0 === n[e] && (n[e] = {}), !1 === n[e] && delete n[e]);
            }),
            { params: n, passedParams: o, rest: i, events: r }
        );
    }
    function ng(e = {}, t, n) {
        const r = [],
            o = { 'container-start': [], 'container-end': [], 'wrapper-start': [], 'wrapper-end': [] },
            i = (e, t) => {
                Array.isArray(e) &&
                    e.forEach(e => {
                        const n = 'symbol' == typeof e.type;
                        ('default' === t && (t = 'container-end'),
                            n && e.children
                                ? i(e.children, t)
                                : (e.type &&
                                        ('SwiperSlide' === e.type.name || 'AsyncComponentWrapper' === e.type.name)) ||
                                    (e.componentOptions && 'SwiperSlide' === e.componentOptions.tag)
                                  ? r.push(e)
                                  : o[t] && o[t].push(e));
                    });
            };
        return (
            Object.keys(e).forEach(t => {
                if ('function' != typeof e[t]) return;
                const n = e[t]();
                i(n, t);
            }),
            (n.value = t.value),
            (t.value = r),
            { slides: r, slots: o }
        );
    }
    const rg = {
            name: 'Swiper',
            props: {
                tag: { type: String, default: 'div' },
                wrapperTag: { type: String, default: 'div' },
                modules: { type: Array, default: void 0 },
                init: { type: Boolean, default: void 0 },
                direction: { type: String, default: void 0 },
                oneWayMovement: { type: Boolean, default: void 0 },
                swiperElementNodeName: { type: String, default: 'SWIPER-CONTAINER' },
                touchEventsTarget: { type: String, default: void 0 },
                initialSlide: { type: Number, default: void 0 },
                speed: { type: Number, default: void 0 },
                cssMode: { type: Boolean, default: void 0 },
                updateOnWindowResize: { type: Boolean, default: void 0 },
                resizeObserver: { type: Boolean, default: void 0 },
                nested: { type: Boolean, default: void 0 },
                focusableElements: { type: String, default: void 0 },
                width: { type: Number, default: void 0 },
                height: { type: Number, default: void 0 },
                preventInteractionOnTransition: { type: Boolean, default: void 0 },
                userAgent: { type: String, default: void 0 },
                url: { type: String, default: void 0 },
                edgeSwipeDetection: { type: [Boolean, String], default: void 0 },
                edgeSwipeThreshold: { type: Number, default: void 0 },
                autoHeight: { type: Boolean, default: void 0 },
                setWrapperSize: { type: Boolean, default: void 0 },
                virtualTranslate: { type: Boolean, default: void 0 },
                effect: { type: String, default: void 0 },
                breakpoints: { type: Object, default: void 0 },
                breakpointsBase: { type: String, default: void 0 },
                spaceBetween: { type: [Number, String], default: void 0 },
                slidesPerView: { type: [Number, String], default: void 0 },
                maxBackfaceHiddenSlides: { type: Number, default: void 0 },
                slidesPerGroup: { type: Number, default: void 0 },
                slidesPerGroupSkip: { type: Number, default: void 0 },
                slidesPerGroupAuto: { type: Boolean, default: void 0 },
                centeredSlides: { type: Boolean, default: void 0 },
                centeredSlidesBounds: { type: Boolean, default: void 0 },
                slidesOffsetBefore: { type: Number, default: void 0 },
                slidesOffsetAfter: { type: Number, default: void 0 },
                normalizeSlideIndex: { type: Boolean, default: void 0 },
                centerInsufficientSlides: { type: Boolean, default: void 0 },
                watchOverflow: { type: Boolean, default: void 0 },
                roundLengths: { type: Boolean, default: void 0 },
                touchRatio: { type: Number, default: void 0 },
                touchAngle: { type: Number, default: void 0 },
                simulateTouch: { type: Boolean, default: void 0 },
                shortSwipes: { type: Boolean, default: void 0 },
                longSwipes: { type: Boolean, default: void 0 },
                longSwipesRatio: { type: Number, default: void 0 },
                longSwipesMs: { type: Number, default: void 0 },
                followFinger: { type: Boolean, default: void 0 },
                allowTouchMove: { type: Boolean, default: void 0 },
                threshold: { type: Number, default: void 0 },
                touchMoveStopPropagation: { type: Boolean, default: void 0 },
                touchStartPreventDefault: { type: Boolean, default: void 0 },
                touchStartForcePreventDefault: { type: Boolean, default: void 0 },
                touchReleaseOnEdges: { type: Boolean, default: void 0 },
                uniqueNavElements: { type: Boolean, default: void 0 },
                resistance: { type: Boolean, default: void 0 },
                resistanceRatio: { type: Number, default: void 0 },
                watchSlidesProgress: { type: Boolean, default: void 0 },
                grabCursor: { type: Boolean, default: void 0 },
                preventClicks: { type: Boolean, default: void 0 },
                preventClicksPropagation: { type: Boolean, default: void 0 },
                slideToClickedSlide: { type: Boolean, default: void 0 },
                loop: { type: Boolean, default: void 0 },
                loopedSlides: { type: Number, default: void 0 },
                loopPreventsSliding: { type: Boolean, default: void 0 },
                loopAdditionalSlides: { type: Number, default: void 0 },
                loopAddBlankSlides: { type: Boolean, default: void 0 },
                rewind: { type: Boolean, default: void 0 },
                allowSlidePrev: { type: Boolean, default: void 0 },
                allowSlideNext: { type: Boolean, default: void 0 },
                swipeHandler: { type: Boolean, default: void 0 },
                noSwiping: { type: Boolean, default: void 0 },
                noSwipingClass: { type: String, default: void 0 },
                noSwipingSelector: { type: String, default: void 0 },
                passiveListeners: { type: Boolean, default: void 0 },
                containerModifierClass: { type: String, default: void 0 },
                slideClass: { type: String, default: void 0 },
                slideActiveClass: { type: String, default: void 0 },
                slideVisibleClass: { type: String, default: void 0 },
                slideFullyVisibleClass: { type: String, default: void 0 },
                slideBlankClass: { type: String, default: void 0 },
                slideNextClass: { type: String, default: void 0 },
                slidePrevClass: { type: String, default: void 0 },
                wrapperClass: { type: String, default: void 0 },
                lazyPreloaderClass: { type: String, default: void 0 },
                lazyPreloadPrevNext: { type: Number, default: void 0 },
                runCallbacksOnInit: { type: Boolean, default: void 0 },
                observer: { type: Boolean, default: void 0 },
                observeParents: { type: Boolean, default: void 0 },
                observeSlideChildren: { type: Boolean, default: void 0 },
                a11y: { type: [Boolean, Object], default: void 0 },
                autoplay: { type: [Boolean, Object], default: void 0 },
                controller: { type: Object, default: void 0 },
                coverflowEffect: { type: Object, default: void 0 },
                cubeEffect: { type: Object, default: void 0 },
                fadeEffect: { type: Object, default: void 0 },
                flipEffect: { type: Object, default: void 0 },
                creativeEffect: { type: Object, default: void 0 },
                cardsEffect: { type: Object, default: void 0 },
                hashNavigation: { type: [Boolean, Object], default: void 0 },
                history: { type: [Boolean, Object], default: void 0 },
                keyboard: { type: [Boolean, Object], default: void 0 },
                mousewheel: { type: [Boolean, Object], default: void 0 },
                navigation: { type: [Boolean, Object], default: void 0 },
                pagination: { type: [Boolean, Object], default: void 0 },
                parallax: { type: [Boolean, Object], default: void 0 },
                scrollbar: { type: [Boolean, Object], default: void 0 },
                thumbs: { type: Object, default: void 0 },
                virtual: { type: [Boolean, Object], default: void 0 },
                zoom: { type: [Boolean, Object], default: void 0 },
                grid: { type: [Object], default: void 0 },
                freeMode: { type: [Boolean, Object], default: void 0 },
                enabled: { type: Boolean, default: void 0 }
            },
            emits: [
                '_beforeBreakpoint',
                '_containerClasses',
                '_slideClass',
                '_slideClasses',
                '_swiper',
                '_freeModeNoMomentumRelease',
                '_virtualUpdated',
                'activeIndexChange',
                'afterInit',
                'autoplay',
                'autoplayStart',
                'autoplayStop',
                'autoplayPause',
                'autoplayResume',
                'autoplayTimeLeft',
                'beforeDestroy',
                'beforeInit',
                'beforeLoopFix',
                'beforeResize',
                'beforeSlideChangeStart',
                'beforeTransitionStart',
                'breakpoint',
                'changeDirection',
                'click',
                'disable',
                'doubleTap',
                'doubleClick',
                'destroy',
                'enable',
                'fromEdge',
                'hashChange',
                'hashSet',
                'init',
                'keyPress',
                'lock',
                'loopFix',
                'momentumBounce',
                'navigationHide',
                'navigationShow',
                'navigationPrev',
                'navigationNext',
                'observerUpdate',
                'orientationchange',
                'paginationHide',
                'paginationRender',
                'paginationShow',
                'paginationUpdate',
                'progress',
                'reachBeginning',
                'reachEnd',
                'realIndexChange',
                'resize',
                'scroll',
                'scrollbarDragEnd',
                'scrollbarDragMove',
                'scrollbarDragStart',
                'setTransition',
                'setTranslate',
                'slidesUpdated',
                'slideChange',
                'slideChangeTransitionEnd',
                'slideChangeTransitionStart',
                'slideNextTransitionEnd',
                'slideNextTransitionStart',
                'slidePrevTransitionEnd',
                'slidePrevTransitionStart',
                'slideResetTransitionStart',
                'slideResetTransitionEnd',
                'sliderMove',
                'sliderFirstMove',
                'slidesLengthChange',
                'slidesGridLengthChange',
                'snapGridLengthChange',
                'snapIndexChange',
                'swiper',
                'tap',
                'toEdge',
                'touchEnd',
                'touchMove',
                'touchMoveOpposite',
                'touchStart',
                'transitionEnd',
                'transitionStart',
                'unlock',
                'update',
                'virtualUpdate',
                'zoomChange'
            ],
            setup(e, { slots: t, emit: n }) {
                const { tag: r, wrapperTag: o } = e,
                    i = Jt('swiper'),
                    s = Jt(null),
                    a = Jt(!1),
                    l = Jt(!1),
                    c = Jt(null),
                    d = Jt(null),
                    u = Jt(null),
                    p = { value: [] },
                    f = { value: [] },
                    h = Jt(null),
                    m = Jt(null),
                    g = Jt(null),
                    v = Jt(null),
                    { params: y, passedParams: b } = tg(e, !1);
                (ng(t, p, f),
                    (u.value = b),
                    (f.value = p.value),
                    (y.onAny = (e, ...t) => {
                        n(e, ...t);
                    }),
                    Object.assign(y.on, {
                        _beforeBreakpoint: () => {
                            (ng(t, p, f), (a.value = !0));
                        },
                        _containerClasses(e, t) {
                            i.value = t;
                        }
                    }));
                const w = { ...y };
                if ((delete w.wrapperClass, (d.value = new Wm(w)), d.value.virtual && d.value.params.virtual.enabled)) {
                    d.value.virtual.slides = p.value;
                    const e = {
                        cache: !1,
                        slides: p.value,
                        renderExternal: e => {
                            s.value = e;
                        },
                        renderExternalUpdate: !1
                    };
                    (Km(d.value.params.virtual, e), Km(d.value.originalParams.virtual, e));
                }
                function S(e) {
                    return y.virtual
                        ? (function (e, t, n) {
                              if (!n) return null;
                              const r = e => {
                                      let n = e;
                                      return (e < 0 ? (n = t.length + e) : n >= t.length && (n -= t.length), n);
                                  },
                                  o = e.value.isHorizontal()
                                      ? { [e.value.rtlTranslate ? 'right' : 'left']: `${n.offset}px` }
                                      : { top: `${n.offset}px` },
                                  { from: i, to: s } = n,
                                  a = e.value.params.loop ? -t.length : 0,
                                  l = e.value.params.loop ? 2 * t.length : t.length,
                                  c = [];
                              for (let e = a; e < l; e += 1) e >= i && e <= s && c.length < t.length && c.push(t[r(e)]);
                              return c.map(
                                  t => (
                                      t.props || (t.props = {}),
                                      t.props.style || (t.props.style = {}),
                                      (t.props.swiperRef = e),
                                      (t.props.style = o),
                                      t.type
                                          ? Sl(t.type, { ...t.props }, t.children)
                                          : t.componentOptions
                                            ? Sl(t.componentOptions.Ctor, { ...t.props }, t.componentOptions.children)
                                            : void 0
                                  )
                              );
                          })(d, e, s.value)
                        : (e.forEach((e, t) => {
                              (e.props || (e.props = {}), (e.props.swiperRef = d), (e.props.swiperSlideIndex = t));
                          }),
                          e);
                }
                return (
                    qo(() => {
                        !l.value && d.value && (d.value.emitSlidesClasses(), (l.value = !0));
                        const { passedParams: t } = tg(e, !1),
                            n = (function (e, t, n, r, o) {
                                const i = [];
                                if (!t) return i;
                                const s = e => {
                                    i.indexOf(e) < 0 && i.push(e);
                                };
                                if (n && r) {
                                    const e = r.map(o),
                                        t = n.map(o);
                                    (e.join('') !== t.join('') && s('children'),
                                        r.length !== n.length && s('children'));
                                }
                                return (
                                    Gm.filter(e => '_' === e[0])
                                        .map(e => e.replace(/_/, ''))
                                        .forEach(n => {
                                            if (n in e && n in t)
                                                if (Ym(e[n]) && Ym(t[n])) {
                                                    const r = Object.keys(e[n]),
                                                        o = Object.keys(t[n]);
                                                    r.length !== o.length
                                                        ? s(n)
                                                        : (r.forEach(r => {
                                                              e[n][r] !== t[n][r] && s(n);
                                                          }),
                                                          o.forEach(r => {
                                                              e[n][r] !== t[n][r] && s(n);
                                                          }));
                                                } else e[n] !== t[n] && s(n);
                                        }),
                                    i
                                );
                            })(t, u.value, p.value, f.value, e => e.props && e.props.key);
                        ((u.value = t),
                            (n.length || a.value) &&
                                d.value &&
                                !d.value.destroyed &&
                                (function ({
                                    swiper: e,
                                    slides: t,
                                    passedParams: n,
                                    changedParams: r,
                                    nextEl: o,
                                    prevEl: i,
                                    scrollbarEl: s,
                                    paginationEl: a
                                }) {
                                    const l = r.filter(
                                            e => 'children' !== e && 'direction' !== e && 'wrapperClass' !== e
                                        ),
                                        {
                                            params: c,
                                            pagination: d,
                                            navigation: u,
                                            scrollbar: p,
                                            virtual: f,
                                            thumbs: h
                                        } = e;
                                    let m, g, v, y, b, w, S, x;
                                    (r.includes('thumbs') &&
                                        n.thumbs &&
                                        n.thumbs.swiper &&
                                        !n.thumbs.swiper.destroyed &&
                                        c.thumbs &&
                                        (!c.thumbs.swiper || c.thumbs.swiper.destroyed) &&
                                        (m = !0),
                                        r.includes('controller') &&
                                            n.controller &&
                                            n.controller.control &&
                                            c.controller &&
                                            !c.controller.control &&
                                            (g = !0),
                                        r.includes('pagination') &&
                                            n.pagination &&
                                            (n.pagination.el || a) &&
                                            (c.pagination || !1 === c.pagination) &&
                                            d &&
                                            !d.el &&
                                            (v = !0),
                                        r.includes('scrollbar') &&
                                            n.scrollbar &&
                                            (n.scrollbar.el || s) &&
                                            (c.scrollbar || !1 === c.scrollbar) &&
                                            p &&
                                            !p.el &&
                                            (y = !0),
                                        r.includes('navigation') &&
                                            n.navigation &&
                                            (n.navigation.prevEl || i) &&
                                            (n.navigation.nextEl || o) &&
                                            (c.navigation || !1 === c.navigation) &&
                                            u &&
                                            !u.prevEl &&
                                            !u.nextEl &&
                                            (b = !0));
                                    const _ = t => {
                                        e[t] &&
                                            (e[t].destroy(),
                                            'navigation' === t
                                                ? (e.isElement && (e[t].prevEl.remove(), e[t].nextEl.remove()),
                                                  (c[t].prevEl = void 0),
                                                  (c[t].nextEl = void 0),
                                                  (e[t].prevEl = void 0),
                                                  (e[t].nextEl = void 0))
                                                : (e.isElement && e[t].el.remove(),
                                                  (c[t].el = void 0),
                                                  (e[t].el = void 0)));
                                    };
                                    (r.includes('loop') &&
                                        e.isElement &&
                                        (c.loop && !n.loop ? (w = !0) : !c.loop && n.loop ? (S = !0) : (x = !0)),
                                        l.forEach(e => {
                                            if (Ym(c[e]) && Ym(n[e]))
                                                (Object.assign(c[e], n[e]),
                                                    ('navigation' !== e && 'pagination' !== e && 'scrollbar' !== e) ||
                                                        !('enabled' in n[e]) ||
                                                        n[e].enabled ||
                                                        _(e));
                                            else {
                                                const t = n[e];
                                                (!0 !== t && !1 !== t) ||
                                                ('navigation' !== e && 'pagination' !== e && 'scrollbar' !== e)
                                                    ? (c[e] = n[e])
                                                    : !1 === t && _(e);
                                            }
                                        }),
                                        l.includes('controller') &&
                                            !g &&
                                            e.controller &&
                                            e.controller.control &&
                                            c.controller &&
                                            c.controller.control &&
                                            (e.controller.control = c.controller.control),
                                        r.includes('children') && t && f && c.virtual.enabled
                                            ? ((f.slides = t), f.update(!0))
                                            : r.includes('virtual') &&
                                              f &&
                                              c.virtual.enabled &&
                                              (t && (f.slides = t), f.update(!0)),
                                        r.includes('children') && t && c.loop && (x = !0),
                                        m && h.init() && h.update(!0),
                                        g && (e.controller.control = c.controller.control),
                                        v &&
                                            (!e.isElement ||
                                                (a && 'string' != typeof a) ||
                                                ((a = document.createElement('div')).classList.add('swiper-pagination'),
                                                a.part.add('pagination'),
                                                e.el.appendChild(a)),
                                            a && (c.pagination.el = a),
                                            d.init(),
                                            d.render(),
                                            d.update()),
                                        y &&
                                            (!e.isElement ||
                                                (s && 'string' != typeof s) ||
                                                ((s = document.createElement('div')).classList.add('swiper-scrollbar'),
                                                s.part.add('scrollbar'),
                                                e.el.appendChild(s)),
                                            s && (c.scrollbar.el = s),
                                            p.init(),
                                            p.updateSize(),
                                            p.setTranslate()),
                                        b &&
                                            (e.isElement &&
                                                ((o && 'string' != typeof o) ||
                                                    ((o = document.createElement('div')).classList.add(
                                                        'swiper-button-next'
                                                    ),
                                                    lm(o, e.navigation.arrowSvg),
                                                    o.part.add('button-next'),
                                                    e.el.appendChild(o)),
                                                (i && 'string' != typeof i) ||
                                                    ((i = document.createElement('div')).classList.add(
                                                        'swiper-button-prev'
                                                    ),
                                                    lm(i, e.navigation.arrowSvg),
                                                    i.part.add('button-prev'),
                                                    e.el.appendChild(i))),
                                            o && (c.navigation.nextEl = o),
                                            i && (c.navigation.prevEl = i),
                                            u.init(),
                                            u.update()),
                                        r.includes('allowSlideNext') && (e.allowSlideNext = n.allowSlideNext),
                                        r.includes('allowSlidePrev') && (e.allowSlidePrev = n.allowSlidePrev),
                                        r.includes('direction') && e.changeDirection(n.direction, !1),
                                        (w || x) && e.loopDestroy(),
                                        (S || x) && e.loopCreate(),
                                        e.update());
                                })({
                                    swiper: d.value,
                                    slides: p.value,
                                    passedParams: t,
                                    changedParams: n,
                                    nextEl: h.value,
                                    prevEl: m.value,
                                    scrollbarEl: v.value,
                                    paginationEl: g.value
                                }),
                            (a.value = !1));
                    }),
                    Yi('swiper', d),
                    ns(s, () => {
                        Un(() => {
                            (e => {
                                !e ||
                                    e.destroyed ||
                                    !e.params.virtual ||
                                    (e.params.virtual && !e.params.virtual.enabled) ||
                                    (e.updateSlides(),
                                    e.updateProgress(),
                                    e.updateSlidesClasses(),
                                    e.emit('_virtualUpdated'),
                                    e.parallax &&
                                        e.params.parallax &&
                                        e.params.parallax.enabled &&
                                        e.parallax.setTranslate());
                            })(d.value);
                        });
                    }),
                    Ho(() => {
                        c.value &&
                            ((function (
                                { el: e, nextEl: t, prevEl: n, paginationEl: r, scrollbarEl: o, swiper: i },
                                s
                            ) {
                                (Xm(s) &&
                                    t &&
                                    n &&
                                    ((i.params.navigation.nextEl = t),
                                    (i.originalParams.navigation.nextEl = t),
                                    (i.params.navigation.prevEl = n),
                                    (i.originalParams.navigation.prevEl = n)),
                                    Jm(s) && r && ((i.params.pagination.el = r), (i.originalParams.pagination.el = r)),
                                    Qm(s) && o && ((i.params.scrollbar.el = o), (i.originalParams.scrollbar.el = o)),
                                    i.init(e));
                            })(
                                {
                                    el: c.value,
                                    nextEl: h.value,
                                    prevEl: m.value,
                                    paginationEl: g.value,
                                    scrollbarEl: v.value,
                                    swiper: d.value
                                },
                                y
                            ),
                            n('swiper', d.value));
                    }),
                    Wo(() => {
                        d.value && !d.value.destroyed && d.value.destroy(!0, !1);
                    }),
                    () => {
                        const { slides: n, slots: s } = ng(t, p, f);
                        return Sl(r, { ref: c, class: Zm(i.value) }, [
                            s['container-start'],
                            Sl(o, { class: eg(y.wrapperClass) }, [s['wrapper-start'], S(n), s['wrapper-end']]),
                            Xm(e) && [
                                Sl('div', { ref: m, class: 'swiper-button-prev' }),
                                Sl('div', { ref: h, class: 'swiper-button-next' })
                            ],
                            Qm(e) && Sl('div', { ref: v, class: 'swiper-scrollbar' }),
                            Jm(e) && Sl('div', { ref: g, class: 'swiper-pagination' }),
                            s['container-end']
                        ]);
                    }
                );
            }
        },
        og = {
            name: 'SwiperSlide',
            props: {
                tag: { type: String, default: 'div' },
                swiperRef: { type: Object, required: !1 },
                swiperSlideIndex: { type: Number, default: void 0, required: !1 },
                zoom: { type: Boolean, default: void 0, required: !1 },
                lazy: { type: Boolean, default: !1, required: !1 },
                virtualIndex: { type: [String, Number], default: void 0 }
            },
            setup(e, { slots: t }) {
                let n = !1;
                const { swiperRef: r } = e,
                    o = Jt(null),
                    i = Jt('swiper-slide'),
                    s = Jt(!1);
                function a(e, t, n) {
                    t === o.value && (i.value = n);
                }
                (Ho(() => {
                    r && r.value && (r.value.on('_slideClass', a), (n = !0));
                }),
                    Uo(() => {
                        !n && r && r.value && (r.value.on('_slideClass', a), (n = !0));
                    }),
                    qo(() => {
                        o.value &&
                            r &&
                            r.value &&
                            (void 0 !== e.swiperSlideIndex && (o.value.swiperSlideIndex = e.swiperSlideIndex),
                            r.value.destroyed && 'swiper-slide' !== i.value && (i.value = 'swiper-slide'));
                    }),
                    Wo(() => {
                        r && r.value && r.value.off('_slideClass', a);
                    }));
                const l = wl(() => ({
                    isActive: i.value.indexOf('swiper-slide-active') >= 0,
                    isVisible: i.value.indexOf('swiper-slide-visible') >= 0,
                    isPrev: i.value.indexOf('swiper-slide-prev') >= 0,
                    isNext: i.value.indexOf('swiper-slide-next') >= 0
                }));
                Yi('swiperSlide', l);
                const c = () => {
                    s.value = !0;
                };
                return () =>
                    Sl(
                        e.tag,
                        {
                            class: Zm(`${i.value}`),
                            ref: o,
                            'data-swiper-slide-index':
                                void 0 === e.virtualIndex && r && r.value && r.value.params.loop
                                    ? e.swiperSlideIndex
                                    : e.virtualIndex,
                            onLoadCapture: c
                        },
                        e.zoom
                            ? Sl(
                                  'div',
                                  {
                                      class: 'swiper-zoom-container',
                                      'data-swiper-zoom': 'number' == typeof e.zoom ? e.zoom : void 0
                                  },
                                  [
                                      t.default && t.default(l.value),
                                      e.lazy && !s.value && Sl('div', { class: 'swiper-lazy-preloader' })
                                  ]
                              )
                            : [
                                  t.default && t.default(l.value),
                                  e.lazy && !s.value && Sl('div', { class: 'swiper-lazy-preloader' })
                              ]
                    );
            }
        };
    function ig({ swiper: e, extendParams: t, on: n, emit: r, params: o }) {
        let i, s;
        ((e.autoplay = { running: !1, paused: !1, timeLeft: 0 }),
            t({
                autoplay: {
                    enabled: !1,
                    delay: 3e3,
                    waitForTransition: !0,
                    disableOnInteraction: !1,
                    stopOnLastSlide: !1,
                    reverseDirection: !1,
                    pauseOnMouseEnter: !1
                }
            }));
        let a,
            l,
            c,
            d,
            u,
            p,
            f,
            h,
            m = o && o.autoplay ? o.autoplay.delay : 3e3,
            g = o && o.autoplay ? o.autoplay.delay : 3e3,
            v = new Date().getTime();
        function y(t) {
            e &&
                !e.destroyed &&
                e.wrapperEl &&
                t.target === e.wrapperEl &&
                (e.wrapperEl.removeEventListener('transitionend', y),
                h || (t.detail && t.detail.bySwiperTouchMove) || T());
        }
        const b = () => {
                if (e.destroyed || !e.autoplay.running) return;
                e.autoplay.paused ? (l = !0) : l && ((g = a), (l = !1));
                const t = e.autoplay.paused ? a : v + g - new Date().getTime();
                ((e.autoplay.timeLeft = t),
                    r('autoplayTimeLeft', t, t / m),
                    (s = requestAnimationFrame(() => {
                        b();
                    })));
            },
            w = t => {
                if (e.destroyed || !e.autoplay.running) return;
                (cancelAnimationFrame(s), b());
                let n = void 0 === t ? e.params.autoplay.delay : t;
                ((m = e.params.autoplay.delay), (g = e.params.autoplay.delay));
                const o = (() => {
                    let t;
                    if (
                        ((t =
                            e.virtual && e.params.virtual.enabled
                                ? e.slides.find(e => e.classList.contains('swiper-slide-active'))
                                : e.slides[e.activeIndex]),
                        t)
                    )
                        return parseInt(t.getAttribute('data-swiper-autoplay'), 10);
                })();
                (!Number.isNaN(o) && o > 0 && void 0 === t && ((n = o), (m = o), (g = o)), (a = n));
                const l = e.params.speed,
                    c = () => {
                        e &&
                            !e.destroyed &&
                            (e.params.autoplay.reverseDirection
                                ? !e.isBeginning || e.params.loop || e.params.rewind
                                    ? (e.slidePrev(l, !0, !0), r('autoplay'))
                                    : e.params.autoplay.stopOnLastSlide ||
                                      (e.slideTo(e.slides.length - 1, l, !0, !0), r('autoplay'))
                                : !e.isEnd || e.params.loop || e.params.rewind
                                  ? (e.slideNext(l, !0, !0), r('autoplay'))
                                  : e.params.autoplay.stopOnLastSlide || (e.slideTo(0, l, !0, !0), r('autoplay')),
                            e.params.cssMode &&
                                ((v = new Date().getTime()),
                                requestAnimationFrame(() => {
                                    w();
                                })));
                    };
                return (
                    n > 0
                        ? (clearTimeout(i),
                          (i = setTimeout(() => {
                              c();
                          }, n)))
                        : requestAnimationFrame(() => {
                              c();
                          }),
                    n
                );
            },
            S = () => {
                ((v = new Date().getTime()), (e.autoplay.running = !0), w(), r('autoplayStart'));
            },
            x = () => {
                ((e.autoplay.running = !1), clearTimeout(i), cancelAnimationFrame(s), r('autoplayStop'));
            },
            _ = (t, n) => {
                if (e.destroyed || !e.autoplay.running) return;
                (clearTimeout(i), t || (f = !0));
                const o = () => {
                    (r('autoplayPause'),
                        e.params.autoplay.waitForTransition ? e.wrapperEl.addEventListener('transitionend', y) : T());
                };
                if (((e.autoplay.paused = !0), n)) return (p && (a = e.params.autoplay.delay), (p = !1), void o());
                const s = a || e.params.autoplay.delay;
                ((a = s - (new Date().getTime() - v)), (e.isEnd && a < 0 && !e.params.loop) || (a < 0 && (a = 0), o()));
            },
            T = () => {
                (e.isEnd && a < 0 && !e.params.loop) ||
                    e.destroyed ||
                    !e.autoplay.running ||
                    ((v = new Date().getTime()),
                    f ? ((f = !1), w(a)) : w(),
                    (e.autoplay.paused = !1),
                    r('autoplayResume'));
            },
            C = () => {
                if (e.destroyed || !e.autoplay.running) return;
                const t = Wh();
                ('hidden' === t.visibilityState && ((f = !0), _(!0)), 'visible' === t.visibilityState && T());
            },
            k = t => {
                'mouse' === t.pointerType && ((f = !0), (h = !0), e.animating || e.autoplay.paused || _(!0));
            },
            E = t => {
                'mouse' === t.pointerType && ((h = !1), e.autoplay.paused && T());
            };
        (n('init', () => {
            e.params.autoplay.enabled &&
                (e.params.autoplay.pauseOnMouseEnter &&
                    (e.el.addEventListener('pointerenter', k), e.el.addEventListener('pointerleave', E)),
                Wh().addEventListener('visibilitychange', C),
                S());
        }),
            n('destroy', () => {
                (e.el &&
                    'string' != typeof e.el &&
                    (e.el.removeEventListener('pointerenter', k), e.el.removeEventListener('pointerleave', E)),
                    Wh().removeEventListener('visibilitychange', C),
                    e.autoplay.running && x());
            }),
            n('_freeModeStaticRelease', () => {
                (d || f) && T();
            }),
            n('_freeModeNoMomentumRelease', () => {
                e.params.autoplay.disableOnInteraction ? x() : _(!0, !0);
            }),
            n('beforeTransitionStart', (t, n, r) => {
                !e.destroyed && e.autoplay.running && (r || !e.params.autoplay.disableOnInteraction ? _(!0, !0) : x());
            }),
            n('sliderFirstMove', () => {
                !e.destroyed &&
                    e.autoplay.running &&
                    (e.params.autoplay.disableOnInteraction
                        ? x()
                        : ((c = !0),
                          (d = !1),
                          (f = !1),
                          (u = setTimeout(() => {
                              ((f = !0), (d = !0), _(!0));
                          }, 200))));
            }),
            n('touchEnd', () => {
                if (!e.destroyed && e.autoplay.running && c) {
                    if ((clearTimeout(u), clearTimeout(i), e.params.autoplay.disableOnInteraction))
                        return ((d = !1), void (c = !1));
                    (d && e.params.cssMode && T(), (d = !1), (c = !1));
                }
            }),
            n('slideChange', () => {
                !e.destroyed && e.autoplay.running && (p = !0);
            }),
            Object.assign(e.autoplay, { start: S, stop: x, pause: _, resume: T }));
    }
    var sg = n(72),
        ag = n.n(sg),
        lg = n(84);
    function cg(e) {
        return (
            (cg =
                'function' == typeof Symbol && 'symbol' == typeof Symbol.iterator
                    ? function (e) {
                          return typeof e;
                      }
                    : function (e) {
                          return e && 'function' == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype
                              ? 'symbol'
                              : typeof e;
                      }),
            cg(e)
        );
    }
    function dg(e, t) {
        var n = Object.keys(e);
        if (Object.getOwnPropertySymbols) {
            var r = Object.getOwnPropertySymbols(e);
            (t &&
                (r = r.filter(function (t) {
                    return Object.getOwnPropertyDescriptor(e, t).enumerable;
                })),
                n.push.apply(n, r));
        }
        return n;
    }
    function ug(e) {
        for (var t = 1; t < arguments.length; t++) {
            var n = null != arguments[t] ? arguments[t] : {};
            t % 2
                ? dg(Object(n), !0).forEach(function (t) {
                      pg(e, t, n[t]);
                  })
                : Object.getOwnPropertyDescriptors
                  ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                  : dg(Object(n)).forEach(function (t) {
                        Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                    });
        }
        return e;
    }
    function pg(e, t, n) {
        return (
            (t = (function (e) {
                var t = (function (e) {
                    if ('object' != cg(e) || !e) return e;
                    var t = e[Symbol.toPrimitive];
                    if (void 0 !== t) {
                        var n = t.call(e, 'string');
                        if ('object' != cg(n)) return n;
                        throw new TypeError('@@toPrimitive must return a primitive value.');
                    }
                    return String(e);
                })(e);
                return 'symbol' == cg(t) ? t : t + '';
            })(t)) in e
                ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 })
                : (e[t] = n),
            e
        );
    }
    function fg(e) {
        return (
            (function (e) {
                if (Array.isArray(e)) return hg(e);
            })(e) ||
            (function (e) {
                if (('undefined' != typeof Symbol && null != e[Symbol.iterator]) || null != e['@@iterator'])
                    return Array.from(e);
            })(e) ||
            (function (e, t) {
                if (e) {
                    if ('string' == typeof e) return hg(e, t);
                    var n = {}.toString.call(e).slice(8, -1);
                    return (
                        'Object' === n && e.constructor && (n = e.constructor.name),
                        'Map' === n || 'Set' === n
                            ? Array.from(e)
                            : 'Arguments' === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
                              ? hg(e, t)
                              : void 0
                    );
                }
            })(e) ||
            (function () {
                throw new TypeError(
                    'Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
                );
            })()
        );
    }
    function hg(e, t) {
        (null == t || t > e.length) && (t = e.length);
        for (var n = 0, r = Array(t); n < t; n++) r[n] = e[n];
        return r;
    }
    function mg(e) {
        return 'function' == typeof e || ('[object Object]' === Object.prototype.toString.call(e) && !Aa(e));
    }
    (ag()(lg.A, { insert: 'head', singleton: !1 }), lg.A.locals);
    const gg = to({
            name: 'Testimonials',
            components: { Swiper: rg, SwiperSlide: og },
            props: {
                title: { type: String, required: !0 },
                subtitle: { type: String, default: '' },
                itemsRow1: { type: Array, required: !0 },
                itemsRow2: { type: Array, required: !0 },
                titleColor: { type: String, default: '#153E35' },
                subtitleColor: { type: String, default: '#6b7280' },
                bgColor: { type: String, default: '#F3F7F5' },
                cardBgColor: { type: String, default: '#ffffff' },
                starColor: { type: String, default: '#C6F432' },
                speed: { type: Number, default: 5e3 },
                secondRowSpeed: { type: Number, default: 7e3 },
                buttonText: { type: String, default: 'See more' },
                buttonUrl: { type: String, default: '#' },
                buttonBgColor: { type: String, default: '#C6F432' },
                buttonTextColor: { type: String, default: '#153E35' }
            },
            setup: function (e) {
                var t = function (e) {
                        for (
                            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 3, n = [], r = 0;
                            r < t;
                            r++
                        )
                            n.push.apply(n, fg(e));
                        return n;
                    },
                    n = {
                        modules: [ig],
                        loop: !0,
                        loopAdditionalSlides: 3,
                        slidesPerView: 'auto',
                        spaceBetween: 24,
                        centeredSlides: !0,
                        allowTouchMove: !1,
                        autoplay: { delay: 0, disableOnInteraction: !1, pauseOnMouseEnter: !0, reverseDirection: !1 },
                        freeMode: !0,
                        freeModeMomentum: !1,
                        breakpoints: {
                            320: { slidesPerView: 1, spaceBetween: 16, centeredSlides: !1 },
                            768: { slidesPerView: 2, spaceBetween: 24 },
                            1024: { slidesPerView: 3, spaceBetween: 24 },
                            1200: { slidesPerView: 'auto', spaceBetween: 24 }
                        }
                    },
                    r = ug(ug({}, n), {}, { speed: e.speed }),
                    o = ug(ug({}, n), {}, { speed: e.secondRowSpeed }),
                    i = t(e.itemsRow1),
                    s = t(e.itemsRow2),
                    a = function (t) {
                        for (var n = [], r = 0; r < 5; r++)
                            n.push(
                                La('span', { key: r, style: { color: r < t ? e.starColor : '#E5E7EB' } }, [Fa('★')])
                            );
                        return La('div', { class: 'testimonial-stars' }, [n]);
                    };
                return function () {
                    var t, n;
                    return La(
                        'section',
                        {
                            class: 'testimonials-section',
                            style: { backgroundColor: e.bgColor, fontFamily: "'Be Vietnam Pro', sans-serif" }
                        },
                        [
                            La('style', null, [
                                '\n          .testimonials-section {\n            padding: 0 0 80px;\n            overflow: hidden;\n          }\n          .testimonials-container {\n            max-width: 1200px;\n            margin: 0 auto;\n            padding: 0 20px;\n            text-align: center;\n          }\n          .testimonials-header-content {\n            max-width: 700px;\n            margin: 0 auto 48px;\n          }\n          .testimonial-swiper {\n            overflow: visible; /* Show shadows */\n          }\n          .testimonial-swiper .swiper-wrapper {\n            transition-timing-function: linear !important;\n          }\n          .testimonial-content {\n            white-space: normal !important; /* Ensure text wraps */\n          }\n          .testimonial-swiper .swiper-slide {\n            width: 400px;\n            height: auto;\n            display: flex;\n            flex-direction: column;\n          }\n          .testimonial-card {\n            background: '
                                    .concat(
                                        e.cardBgColor,
                                        ';\n            border: 1px solid #F3F4F6;\n            border-radius: 24px;\n            padding: 24px;\n            text-align: left;\n            box-shadow: 0 4px 20px rgba(0,0,0,0.06);\n            display: flex;\n            flex-direction: column;\n            flex-grow: 1;\n          }\n          .testimonial-card-header {\n            display: flex;\n            align-items: center;\n            gap: 16px;\n            margin-bottom: 20px;\n          }\n          .testimonial-avatar {\n            width: 56px;\n            height: 56px;\n            border-radius: 50%;\n            object-fit: cover;\n            flex-shrink: 0;\n          }\n          .testimonial-info {\n            flex-grow: 1;\n          }\n          .testimonial-name {\n            font-weight: 600;\n            font-size: 1.1rem;\n            color: #111827;\n          }\n          .testimonial-role {\n            font-size: 0.9rem;\n            color: #6B7280;\n            margin-top: 4px;\n          }\n          .testimonial-stars {\n            font-size: 1rem;\n            letter-spacing: 1.5px;\n            flex-shrink: 0;\n          }\n          .testimonial-content {\n            color: #4B5563;\n            font-size: 1rem;\n            line-height: 1.6;\n            flex-grow: 1;\n          }\n          .testimonials-button {\n            display: inline-flex;\n            align-items: center;\n            gap: 8px;\n            padding: 12px 24px;\n            border-radius: 9999px;\n            font-weight: 600;\n            font-size: 1rem;\n            text-decoration: none;\n            transition: all 0.2s ease;\n            margin-top: 48px;\n            border: none;\n            cursor: pointer;\n          }\n          .testimonials-button:hover {\n            transform: scale(1.05);\n            box-shadow: 0 6px 16px rgba(0,0,0,0.1);\n          }\n          .button-icon {\n            width: 24px;\n            height: 24px;\n            background-color: '
                                    )
                                    .concat(e.buttonTextColor, ';\n            color: ')
                                    .concat(
                                        e.buttonBgColor,
                                        ';\n            border-radius: 50%;\n            display: flex;\n            align-items: center;\n            justify-content: center;\n            transition: transform 0.2s ease;\n          }\n          .testimonials-button:hover .button-icon {\n             transform: rotate(-45deg);\n          }\n          .button-icon svg {\n            width: 14px;\n            height: 14px;\n          }\n        '
                                    )
                            ]),
                            La('div', { class: 'testimonials-container' }, [
                                La('div', { class: 'testimonials-header-content' }, [
                                    La(
                                        'h2',
                                        {
                                            style: {
                                                fontSize: '2.75rem',
                                                fontWeight: 700,
                                                color: e.titleColor,
                                                marginTop: 0,
                                                marginBottom: '16px'
                                            }
                                        },
                                        [e.title]
                                    ),
                                    e.subtitle &&
                                        La(
                                            'p',
                                            { style: { color: e.subtitleColor, fontSize: '1.1rem', lineHeight: 1.7 } },
                                            [e.subtitle]
                                        )
                                ])
                            ]),
                            La(
                                rg,
                                Ua(r, { class: 'testimonial-swiper' }),
                                mg(
                                    (t = i.map(function (e, t) {
                                        return La(
                                            og,
                                            { key: t },
                                            {
                                                default: function () {
                                                    return [
                                                        La('div', { class: 'testimonial-card' }, [
                                                            La('div', { class: 'testimonial-card-header' }, [
                                                                e.avatar &&
                                                                    La(
                                                                        'img',
                                                                        {
                                                                            src: e.avatar,
                                                                            alt: e.name,
                                                                            class: 'testimonial-avatar'
                                                                        },
                                                                        null
                                                                    ),
                                                                La('div', { class: 'testimonial-info' }, [
                                                                    La('h4', { class: 'testimonial-name' }, [e.name]),
                                                                    e.role &&
                                                                        La('p', { class: 'testimonial-role' }, [e.role])
                                                                ]),
                                                                a(e.stars)
                                                            ]),
                                                            La('p', { class: 'testimonial-content' }, [e.content])
                                                        ])
                                                    ];
                                                }
                                            }
                                        );
                                    }))
                                )
                                    ? t
                                    : {
                                          default: function () {
                                              return [t];
                                          }
                                      }
                            ),
                            La(
                                rg,
                                Ua(o, { class: 'testimonial-swiper', style: { marginTop: '32px' } }),
                                mg(
                                    (n = s.map(function (e, t) {
                                        return La(
                                            og,
                                            { key: 'row2-'.concat(t) },
                                            {
                                                default: function () {
                                                    return [
                                                        La('div', { class: 'testimonial-card' }, [
                                                            La('div', { class: 'testimonial-card-header' }, [
                                                                e.avatar &&
                                                                    La(
                                                                        'img',
                                                                        {
                                                                            src: e.avatar,
                                                                            alt: e.name,
                                                                            class: 'testimonial-avatar'
                                                                        },
                                                                        null
                                                                    ),
                                                                La('div', { class: 'testimonial-info' }, [
                                                                    La('h4', { class: 'testimonial-name' }, [e.name]),
                                                                    e.role &&
                                                                        La('p', { class: 'testimonial-role' }, [e.role])
                                                                ]),
                                                                a(e.stars)
                                                            ]),
                                                            La('p', { class: 'testimonial-content' }, [e.content])
                                                        ])
                                                    ];
                                                }
                                            }
                                        );
                                    }))
                                )
                                    ? n
                                    : {
                                          default: function () {
                                              return [n];
                                          }
                                      }
                            ),
                            La('div', { class: 'testimonials-container' }, [
                                e.buttonText &&
                                    La(
                                        'a',
                                        {
                                            href: e.buttonUrl,
                                            class: 'testimonials-button',
                                            style: { backgroundColor: e.buttonBgColor, color: e.buttonTextColor }
                                        },
                                        [
                                            La('span', null, [e.buttonText]),
                                            La('span', { class: 'button-icon' }, [
                                                La(
                                                    'svg',
                                                    { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' },
                                                    [
                                                        La(
                                                            'path',
                                                            {
                                                                'stroke-linecap': 'round',
                                                                'stroke-linejoin': 'round',
                                                                'stroke-width': '2.5',
                                                                d: 'M13 7l5 5-5 5M6 12h12'
                                                            },
                                                            null
                                                        )
                                                    ]
                                                )
                                            ])
                                        ]
                                    )
                            ])
                        ]
                    );
                };
            }
        }),
        vg = to({
            props: {
                title: { type: String, default: '' },
                subtitle: { type: String, default: '' },
                titleColor: { type: String, default: '#0E6B5C' },
                subtitleColor: { type: String, default: '#6c757d' },
                tabs: { type: String, default: '[]' }
            },
            setup: function (e) {
                return {
                    title: Jt(e.title),
                    subtitle: Jt(e.subtitle),
                    titleColor: Jt(e.titleColor),
                    subtitleColor: Jt(e.subtitleColor),
                    tabs: wl(function () {
                        try {
                            return JSON.parse(e.tabs);
                        } catch (e) {
                            return (console.error('Failed to parse tabs data:', e), []);
                        }
                    })
                };
            },
            template:
                '\n        <section class="section-box">\n            <div class="container mt-120">\n                <div class="row">\n                    <div class="col-lg-12">\n                        <div class="text-center">\n                            <h2 class="mb-20" :style="{ color: titleColor, fontSize: \'36px\' }">{{ title }}</h2>\n                            <p :style="{ color: subtitleColor, fontSize: \'18px\', marginBottom: \'3rem\' }">{{ subtitle }}</p>\n                        </div>\n                    </div>\n                </div>\n                <div class="row mt-140">\n                    <div v-for="(tab, index) in tabs" :key="index" class="col-lg-3 col-md-6 col-sm-6 col-12">\n                        <div class="card-small-square">\n                            <div class="card-image">\n                                <div class="box-image" :style="{ backgroundColor: tab.color }">\n                                    <img :src="tab.icon" :alt="tab.title" />\n                                </div>\n                            </div>\n                            <div class="card-info">\n                                <h6 class="mb-10" :style="{ color: tab.title_color || undefined, fontSize: \'20px\' }">{{ tab.title }}</h6>\n                                <p :style="{ color: tab.description_color || undefined, fontSize: \'18px\' }">{{ tab.description }}</p>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </section>\n    '
        }),
        yg = to({
            name: 'DetailedPrice',
            props: {
                sectionTitle: { type: String, default: 'Bảng Giá Chi Tiết' },
                sectionSubtitle: { type: String, default: 'Lựa chọn gói phù hợp với nhu cầu của bạn' },
                titleColor: { type: String, default: '#0f3d2e' },
                labelColor: { type: String, default: '#0d5e43' },
                plans: {
                    type: Array,
                    default: function () {
                        return [];
                    }
                }
            },
            setup: function (e) {
                (console.log('DetailedPrice props:', e), console.log('Plans:', e.plans));
                var t = { background: '#f5f9f7', padding: '64px 0' },
                    n = { maxWidth: '1100px', margin: '0 auto', padding: '0 20px' },
                    r = { textAlign: 'center', color: e.titleColor, fontSize: '32px', fontWeight: 700, margin: 0 },
                    o = { textAlign: 'center', color: '#6b7f74', marginTop: '8px', fontSize: '15px' },
                    i = {
                        display: 'grid',
                        gridTemplateColumns: '1fr 1fr',
                        gap: '24px',
                        marginTop: '40px',
                        alignItems: 'stretch'
                    },
                    s = {
                        background: '#fff',
                        borderRadius: '20px',
                        overflow: 'hidden',
                        boxShadow: '0 12px 34px rgba(0,0,0,.09)',
                        border: '1px solid #e5ede9'
                    },
                    a = function (e) {
                        return {
                            background: 'linear-gradient(135deg, '
                                .concat(e.headerStartColor || '#1fb383', ' 0%, ')
                                .concat(e.headerEndColor || '#0e8a61', ' 100%)'),
                            color: '#fff',
                            padding: '28px',
                            position: 'relative',
                            minHeight: '190px',
                            display: 'flex',
                            flexDirection: 'column',
                            justifyContent: 'center',
                            alignItems: 'flex-start'
                        };
                    },
                    l = function (e) {
                        return {
                            position: 'absolute',
                            top: '12px',
                            right: '12px',
                            background: e.featuredBgColor || '#0a2818',
                            color: '#fff',
                            padding: '6px 12px',
                            borderRadius: '999px',
                            fontSize: '11px',
                            fontWeight: 800,
                            textTransform: 'uppercase',
                            letterSpacing: '.2px'
                        };
                    },
                    c = { fontSize: '24px', fontWeight: 800, margin: 0 },
                    d = function (t) {
                        return {
                            display: 'inline-flex',
                            alignItems: 'center',
                            alignSelf: 'flex-start',
                            background: t.labelBgColor || '#eaf6f1',
                            color: t.labelTextColor || e.labelColor,
                            borderRadius: '999px',
                            padding: '4px 12px',
                            lineHeight: '1',
                            fontWeight: 800,
                            fontSize: '13px',
                            marginTop: '6px',
                            whiteSpace: 'nowrap'
                        };
                    },
                    u = { marginTop: '16px', display: 'flex', alignItems: 'baseline', gap: '6px' },
                    p = { fontSize: '52px', fontWeight: 900, lineHeight: 1 },
                    f = { fontSize: '16px', fontWeight: 700, opacity: 0.95, marginLeft: '6px' },
                    h = { marginTop: '12px', fontSize: '14px', opacity: 0.95, lineHeight: 1.5 },
                    m = { padding: '26px 28px 28px', background: '#fff' },
                    g = { listStyle: 'none', padding: 0, margin: '12px 0 20px', display: 'grid', rowGap: '10px' },
                    v = {
                        display: 'flex',
                        alignItems: 'center',
                        gap: '10px',
                        color: '#26443a',
                        fontSize: '14px',
                        lineHeight: '1.8'
                    },
                    y = { flex: '0 0 22px', display: 'inline-flex' },
                    b = { display: 'flex', justifyContent: 'center' },
                    w = {
                        display: 'inline-flex',
                        justifyContent: 'center',
                        alignItems: 'center',
                        gap: '8px',
                        padding: '14px 22px',
                        borderRadius: '12px',
                        border: '1.5px solid #cfe6db',
                        background: '#fff',
                        color: '#0b5b40',
                        fontWeight: 800,
                        textDecoration: 'none',
                        fontSize: '15px',
                        transition: 'all 0.2s ease',
                        cursor: 'pointer',
                        width: '100%'
                    };
                return function () {
                    return La('div', { class: 'detailed-price-section detailed-price-wrapper', style: t }, [
                        La('div', { class: 'dp-container', style: n }, [
                            La('h2', { class: 'dp-heading', style: r }, [e.sectionTitle]),
                            La('p', { class: 'dp-subtitle', style: o }, [e.sectionSubtitle]),
                            La('div', { class: 'dp-grid', style: i }, [
                                e.plans.map(function (e, t) {
                                    var n = [
                                        'đặt sân',
                                        'dat san',
                                        'đặt sân ngay',
                                        'dat san ngay',
                                        'bắt đầu ngay',
                                        'bat dau ngay'
                                    ].some(function (t) {
                                        return (e.buttonText || '').toLowerCase().includes(t);
                                    })
                                        ? '/san-gia'
                                        : e.buttonUrl || '/';
                                    return La('div', { class: 'dp-card', style: s, key: t }, [
                                        La('div', { class: 'dp-card-header', style: a(e) }, [
                                            e.isFeatured &&
                                                e.featuredText &&
                                                '' !== e.featuredText.trim() &&
                                                La('div', { class: 'dp-featured-badge', style: l(e) }, [
                                                    e.featuredText
                                                ]),
                                            La('h3', { class: 'dp-plan-title', style: c }, [e.title]),
                                            e.badge &&
                                                '' !== e.badge.trim() &&
                                                La('div', { class: 'dp-plan-badge', style: d(e) }, [e.badge]),
                                            La('div', { class: 'dp-price-wrap', style: u }, [
                                                La('span', { class: 'dp-price', style: p }, [e.price]),
                                                La('span', { class: 'dp-suffix', style: f }, [e.priceSuffix])
                                            ]),
                                            e.note && La('div', { class: 'dp-note', style: h }, [e.note])
                                        ]),
                                        La('div', { class: 'dp-card-body', style: m }, [
                                            e.features &&
                                                e.features.length > 0 &&
                                                La('ul', { style: g }, [
                                                    e.features.map(function (e, t) {
                                                        return La('li', { key: t, style: v }, [
                                                            La('span', { style: y }, [
                                                                La(
                                                                    'svg',
                                                                    {
                                                                        width: '22',
                                                                        height: '22',
                                                                        viewBox: '0 0 24 24',
                                                                        fill: 'none',
                                                                        xmlns: 'http://www.w3.org/2000/svg'
                                                                    },
                                                                    [
                                                                        La(
                                                                            'circle',
                                                                            {
                                                                                cx: '12',
                                                                                cy: '12',
                                                                                r: '10',
                                                                                stroke: '#158a68',
                                                                                'stroke-width': '2'
                                                                            },
                                                                            null
                                                                        ),
                                                                        La(
                                                                            'path',
                                                                            {
                                                                                d: 'M7 12l3 3 7-7',
                                                                                stroke: '#158a68',
                                                                                'stroke-width': '2',
                                                                                'stroke-linecap': 'round',
                                                                                'stroke-linejoin': 'round'
                                                                            },
                                                                            null
                                                                        )
                                                                    ]
                                                                )
                                                            ]),
                                                            La('span', null, [e])
                                                        ]);
                                                    })
                                                ]),
                                            La('div', { style: b }, [
                                                La(
                                                    'a',
                                                    {
                                                        href: n,
                                                        class: 'dp-btn',
                                                        style: w,
                                                        onClick: function (t) {
                                                            return (function (e, t, n) {
                                                                var r = (t || '').toLowerCase();
                                                                if (
                                                                    [
                                                                        'đặt sân',
                                                                        'dat san',
                                                                        'đặt sân ngay',
                                                                        'dat san ngay',
                                                                        'bắt đầu ngay',
                                                                        'bat dau ngay'
                                                                    ].some(function (e) {
                                                                        return r.includes(e);
                                                                    })
                                                                ) {
                                                                    var o;
                                                                    e.preventDefault();
                                                                    var i =
                                                                        null !== (o = window.App) &&
                                                                        void 0 !== o &&
                                                                        o.baseUrl
                                                                            ? ''.concat(window.App.baseUrl, '/san-gia')
                                                                            : '/san-gia';
                                                                    window.location.href = i;
                                                                } else
                                                                    n ? (window.location.href = n) : e.preventDefault();
                                                            })(t, e.buttonText || 'Bắt Đầu Ngay', n);
                                                        }
                                                    },
                                                    [e.buttonText || 'Bắt Đầu Ngay']
                                                )
                                            ])
                                        ])
                                    ]);
                                })
                            ])
                        ])
                    ]);
                };
            }
        }),
        bg = to({
            name: 'BookingBadmintonCourt',
            props: {
                title: String,
                titleColor: String,
                description: String,
                descriptionColor: String,
                items: Array,
                viewAllText: String,
                viewAllUrl: String,
                viewAllBg: String,
                viewAllColor: String
            },
            setup: function (e) {
                var t = { padding: '64px 0', background: 'transparent' },
                    n = {
                        fontSize: '40px',
                        lineHeight: 1.2,
                        textAlign: 'center',
                        color: e.titleColor || '#0E6B5C',
                        margin: '0 0 10px',
                        fontWeight: 800
                    },
                    r = {
                        fontSize: '16px',
                        textAlign: 'center',
                        color: e.descriptionColor || '#6b7280',
                        margin: '0 auto 36px',
                        maxWidth: '860px'
                    },
                    o = {
                        position: 'absolute',
                        inset: 0,
                        background: 'linear-gradient(to top, rgba(0,0,0,.55), rgba(0,0,0,0))',
                        opacity: 0.65
                    },
                    i = {
                        position: 'absolute',
                        left: '16px',
                        bottom: '16px',
                        display: 'flex',
                        flexWrap: 'wrap',
                        gap: '8px',
                        zIndex: 2
                    },
                    s = { padding: '18px 18px 16px' },
                    a = {
                        margin: '0 0 6px',
                        fontSize: '20px',
                        fontWeight: 800,
                        color: '#111827',
                        transition: 'color .2s ease'
                    },
                    l = { margin: 0, opacity: 0.8, fontSize: '14px', color: '#6b7280' },
                    c = {
                        marginTop: '14px',
                        paddingTop: '14px',
                        borderTop: '1px solid rgba(15, 23, 42, 0.08)',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'space-between',
                        gap: '12px'
                    },
                    d = function (e) {
                        return {
                            fontSize: '12px',
                            fontWeight: 600,
                            color: e.price_label_color || '#6b7280',
                            marginBottom: '2px'
                        };
                    },
                    u = function (e) {
                        return {
                            fontSize: '18px',
                            fontWeight: 900,
                            color: e.price_value_color || '#111827',
                            lineHeight: 1.1
                        };
                    },
                    p = function (e) {
                        return {
                            width: '40px',
                            height: '40px',
                            borderRadius: '999px',
                            display: 'inline-flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            background: e.button_bg_color || 'rgba(5, 150, 105, 0.1)',
                            color: e.button_text_color || '#059669',
                            textDecoration: 'none',
                            transition: 'all .25s ease'
                        };
                    },
                    f = { textAlign: 'center', marginTop: '28px' },
                    h = {
                        display: 'inline-block',
                        borderRadius: '12px',
                        padding: '12px 26px',
                        background: e.viewAllBg || '#065f46',
                        color: e.viewAllColor || '#ffffff',
                        textDecoration: 'none',
                        fontWeight: 800,
                        boxShadow: '0 12px 24px rgba(6, 95, 70, 0.18)'
                    };
                return function () {
                    return La('section', { class: 'booking-badminton-court', style: t }, [
                        e.title && La('h2', { style: n, innerHTML: e.title }, null),
                        e.description && La('p', { style: r, innerHTML: e.description }, null),
                        La('style', null, [
                            '\n            .bbc-grid { display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 24px; }\n            @media (min-width: 768px) { .bbc-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }\n            @media (min-width: 1200px) { .bbc-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }\n\n            .bbc-card:hover { box-shadow: 0 16px 30px rgba(0,0,0,.12); transform: translateY(-2px); border-color: rgba(5, 150, 105, 0.35); }\n            .bbc-card:hover .bbc-image { transform: scale(1.1); }\n            .bbc-card:hover .bbc-title { color: #059669; }\n            .bbc-card:hover .bbc-circle { background: #059669 !important; color: #ffffff !important; }\n          '
                        ]),
                        La('div', { class: 'container' }, [
                            La('div', { class: 'bbc-grid' }, [
                                (e.items || []).slice(0, 8).map(function (e, t) {
                                    return La(
                                        'div',
                                        {
                                            class: 'bbc-card',
                                            style: {
                                                background: '#ffffff',
                                                borderRadius: '16px',
                                                overflow: 'hidden',
                                                border: '1px solid rgba(15, 23, 42, 0.08)',
                                                boxShadow: '0 1px 2px rgba(0,0,0,.05)',
                                                transition:
                                                    'box-shadow .25s ease, transform .25s ease, border-color .25s ease'
                                            },
                                            key: t
                                        },
                                        [
                                            La(
                                                'div',
                                                {
                                                    style:
                                                        (e.image,
                                                        {
                                                            position: 'relative',
                                                            height: '240px',
                                                            overflow: 'hidden',
                                                            backgroundColor: '#e5e7eb'
                                                        })
                                                },
                                                [
                                                    La(
                                                        'div',
                                                        {
                                                            class: 'bbc-image',
                                                            style:
                                                                ((n = e.image),
                                                                {
                                                                    position: 'absolute',
                                                                    inset: 0,
                                                                    backgroundImage: n ? 'url('.concat(n, ')') : void 0,
                                                                    backgroundSize: 'cover',
                                                                    backgroundPosition: 'center',
                                                                    transform: 'scale(1)',
                                                                    transition: 'transform .7s ease'
                                                                })
                                                        },
                                                        null
                                                    ),
                                                    La('div', { style: o }, null),
                                                    La('div', { style: i }, [
                                                        e.time_1 &&
                                                            La(
                                                                'span',
                                                                {
                                                                    style: {
                                                                        background: 'rgba(255,255,255,.9)',
                                                                        color: '#111827',
                                                                        padding: '6px 10px',
                                                                        borderRadius: '10px',
                                                                        fontSize: '12px',
                                                                        fontWeight: 800,
                                                                        boxShadow: '0 1px 2px rgba(0,0,0,.08)',
                                                                        backdropFilter: 'blur(6px)'
                                                                    }
                                                                },
                                                                [e.time_1]
                                                            ),
                                                        e.time_2 &&
                                                            La(
                                                                'span',
                                                                {
                                                                    style: {
                                                                        background: 'rgba(255,255,255,.9)',
                                                                        color: '#111827',
                                                                        padding: '6px 10px',
                                                                        borderRadius: '10px',
                                                                        fontSize: '12px',
                                                                        fontWeight: 800,
                                                                        boxShadow: '0 1px 2px rgba(0,0,0,.08)',
                                                                        backdropFilter: 'blur(6px)'
                                                                    }
                                                                },
                                                                [e.time_2]
                                                            )
                                                    ])
                                                ]
                                            ),
                                            La('div', { style: s }, [
                                                e.title && La('h3', { class: 'bbc-title', style: a }, [e.title]),
                                                e.description && La('p', { style: l }, [e.description]),
                                                La('div', { style: c }, [
                                                    La('div', { style: { minWidth: 0 } }, [
                                                        e.price_label && La('div', { style: d(e) }, [e.price_label]),
                                                        e.price_value && La('div', { style: u(e) }, [e.price_value])
                                                    ]),
                                                    La(
                                                        'a',
                                                        {
                                                            href: e.button_url || '#',
                                                            class: 'bbc-circle',
                                                            style: p(e),
                                                            'aria-label': 'Select'
                                                        },
                                                        [
                                                            La(
                                                                'svg',
                                                                {
                                                                    width: '18',
                                                                    height: '18',
                                                                    viewBox: '0 0 24 24',
                                                                    fill: 'none',
                                                                    xmlns: 'http://www.w3.org/2000/svg'
                                                                },
                                                                [
                                                                    La(
                                                                        'path',
                                                                        {
                                                                            d: 'M9 18l6-6-6-6',
                                                                            stroke: 'currentColor',
                                                                            'stroke-width': '2',
                                                                            'stroke-linecap': 'round',
                                                                            'stroke-linejoin': 'round'
                                                                        },
                                                                        null
                                                                    )
                                                                ]
                                                            )
                                                        ]
                                                    )
                                                ])
                                            ])
                                        ]
                                    );
                                    var n;
                                })
                            ]),
                            (e.viewAllText || e.viewAllUrl) &&
                                La('div', { style: f }, [
                                    La('a', { href: e.viewAllUrl || '#', class: 'btn-view-all', style: h }, [
                                        e.viewAllText || 'Xem tất cả'
                                    ])
                                ])
                        ])
                    ]);
                };
            }
        }),
        wg = to({
            name: 'SelectMembership',
            props: { title: String, subtitle: String, titleColor: String, subtitleColor: String, cards: Array },
            setup: function (e) {
                var t = '#0E6B5C';
                return function () {
                    return La('section', { class: 'select-membership' }, [
                        La('div', { class: 'container' }, [
                            e.title && La('h2', { class: 'sm-title', style: { color: e.titleColor } }, [e.title]),
                            e.subtitle &&
                                La('p', { class: 'sm-subtitle', style: { color: e.subtitleColor } }, [e.subtitle]),
                            La('div', { class: 'sm-grid' }, [
                                (e.cards || []).map(function (e, n) {
                                    return La(
                                        'div',
                                        {
                                            class: ['sm-card', { 'is-featured': e.is_featured }],
                                            style: {
                                                backgroundColor: e.card_bg_color || (e.is_featured ? t : '#FFFFFF'),
                                                borderColor: e.card_border_color || 'transparent'
                                            },
                                            key: n
                                        },
                                        [
                                            e.is_featured &&
                                                e.featured_badge_text &&
                                                La(
                                                    'div',
                                                    {
                                                        class: 'featured-badge',
                                                        style: {
                                                            backgroundColor: e.featured_badge_bg,
                                                            color: e.featured_badge_color
                                                        }
                                                    },
                                                    [e.featured_badge_text]
                                                ),
                                            La('div', { class: 'sm-card-header' }, [
                                                La(
                                                    'div',
                                                    {
                                                        class: 'price',
                                                        style: {
                                                            color: e.price_color || (e.is_featured ? '#fff' : '#000')
                                                        }
                                                    },
                                                    [e.price]
                                                ),
                                                La(
                                                    'h3',
                                                    {
                                                        class: 'title',
                                                        style: { color: e.title_color || (e.is_featured ? '#fff' : t) }
                                                    },
                                                    [e.title]
                                                ),
                                                La(
                                                    'p',
                                                    {
                                                        class: 'subtitle',
                                                        style: {
                                                            color:
                                                                e.subtitle_color ||
                                                                (e.is_featured ? 'rgba(255,255,255,0.8)' : '#6c757d')
                                                        }
                                                    },
                                                    [e.subtitle]
                                                )
                                            ]),
                                            e.discount_badge_text &&
                                                La('div', { class: 'discount-badge-wrap' }, [
                                                    La(
                                                        'span',
                                                        {
                                                            class: 'discount-badge',
                                                            style: {
                                                                backgroundColor: e.discount_badge_bg,
                                                                color: e.discount_badge_color
                                                            }
                                                        },
                                                        [e.discount_badge_text]
                                                    )
                                                ]),
                                            La(
                                                'ul',
                                                {
                                                    class: 'features-list',
                                                    style: {
                                                        color:
                                                            e.features_color ||
                                                            (e.is_featured ? 'rgba(255,255,255,0.95)' : '#333')
                                                    }
                                                },
                                                [
                                                    (e.features || '').split('\n').map(function (e, n) {
                                                        return (
                                                            e.trim() &&
                                                            La('li', { key: n }, [
                                                                La(
                                                                    'svg',
                                                                    {
                                                                        width: '18',
                                                                        height: '18',
                                                                        viewBox: '0 0 24 24',
                                                                        fill: 'none',
                                                                        xmlns: 'http://www.w3.org/2000/svg',
                                                                        style: {
                                                                            marginRight: '8px',
                                                                            color: t,
                                                                            flexShrink: 0
                                                                        }
                                                                    },
                                                                    [
                                                                        La(
                                                                            'path',
                                                                            {
                                                                                d: 'M17.33 8.66998L10.5 15.5L7.66998 12.67',
                                                                                stroke: 'currentColor',
                                                                                'stroke-width': '2',
                                                                                'stroke-linecap': 'round',
                                                                                'stroke-linejoin': 'round'
                                                                            },
                                                                            null
                                                                        ),
                                                                        La(
                                                                            'path',
                                                                            {
                                                                                d: 'M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z',
                                                                                stroke: 'currentColor',
                                                                                'stroke-width': '2',
                                                                                'stroke-linecap': 'round',
                                                                                'stroke-linejoin': 'round'
                                                                            },
                                                                            null
                                                                        )
                                                                    ]
                                                                ),
                                                                La('span', null, [e.trim()])
                                                            ])
                                                        );
                                                    })
                                                ]
                                            ),
                                            La('div', { class: 'sm-card-footer' }, [
                                                La(
                                                    'a',
                                                    {
                                                        href: e.button_url || '#',
                                                        class: 'sm-button',
                                                        onClick: function (t) {
                                                            return (function (e, t, n) {
                                                                var r = (t || '').toLowerCase();
                                                                if (
                                                                    [
                                                                        'đặt sân',
                                                                        'dat san',
                                                                        'đặt sân ngay',
                                                                        'dat san ngay',
                                                                        'bắt đầu ngay',
                                                                        'bat dau ngay'
                                                                    ].some(function (e) {
                                                                        return r.includes(e);
                                                                    })
                                                                ) {
                                                                    var o;
                                                                    e.preventDefault();
                                                                    var i =
                                                                        null !== (o = window.App) &&
                                                                        void 0 !== o &&
                                                                        o.baseUrl
                                                                            ? ''.concat(window.App.baseUrl, '/san-gia')
                                                                            : '/san-gia';
                                                                    window.location.href = i;
                                                                } else n && (window.location.href = n);
                                                            })(t, e.button_text, e.button_url);
                                                        },
                                                        style: {
                                                            backgroundColor: e.button_bg_color,
                                                            color: e.button_text_color
                                                        }
                                                    },
                                                    [
                                                        La('span', null, [e.button_text]),
                                                        La(
                                                            'svg',
                                                            {
                                                                width: '16',
                                                                height: '16',
                                                                viewBox: '0 0 24 24',
                                                                fill: 'none',
                                                                xmlns: 'http://www.w3.org/2000/svg',
                                                                style: { marginLeft: '8px' }
                                                            },
                                                            [
                                                                La(
                                                                    'path',
                                                                    {
                                                                        d: 'M5 12H19',
                                                                        stroke: 'currentColor',
                                                                        'stroke-width': '2',
                                                                        'stroke-linecap': 'round',
                                                                        'stroke-linejoin': 'round'
                                                                    },
                                                                    null
                                                                ),
                                                                La(
                                                                    'path',
                                                                    {
                                                                        d: 'M12 5L19 12L12 19',
                                                                        stroke: 'currentColor',
                                                                        'stroke-width': '2',
                                                                        'stroke-linecap': 'round',
                                                                        'stroke-linejoin': 'round'
                                                                    },
                                                                    null
                                                                )
                                                            ]
                                                        )
                                                    ]
                                                )
                                            ])
                                        ]
                                    );
                                })
                            ])
                        ])
                    ]);
                };
            }
        }),
        Sg = to({
            name: 'ContactUs',
            props: {
                formTitle: String,
                formSubtitle: String,
                contactFormHtml: String,
                locationTitle: String,
                googleMapsIframe: String,
                mainBranchTitle: String,
                mainBranchAddress: String,
                mainBranchPhone: String,
                mainBranchMapUrl: String,
                otherBranchesTitle: String,
                otherBranches: Array
            },
            setup: function (e) {
                return function () {
                    return La('section', { class: 'contact-us-section' }, [
                        La('div', { class: 'container' }, [
                            La('div', { class: 'contact-us-grid' }, [
                                La('div', { class: 'contact-form-wrapper' }, [
                                    e.formTitle && La('h3', null, [e.formTitle]),
                                    e.formSubtitle && La('p', null, [e.formSubtitle]),
                                    La('div', { innerHTML: e.contactFormHtml }, null)
                                ]),
                                La('div', { class: 'location-wrapper' }, [
                                    e.locationTitle && La('h3', null, [e.locationTitle]),
                                    e.googleMapsIframe &&
                                        La(
                                            'div',
                                            { class: 'google-map-container', innerHTML: e.googleMapsIframe },
                                            null
                                        ),
                                    La('div', { class: 'branch-info' }, [
                                        e.mainBranchTitle && La('h4', null, [e.mainBranchTitle]),
                                        e.mainBranchAddress && La('p', { class: 'address' }, [e.mainBranchAddress]),
                                        e.mainBranchPhone && La('p', { class: 'phone' }, [e.mainBranchPhone]),
                                        e.mainBranchMapUrl &&
                                            La(
                                                'a',
                                                {
                                                    href: e.mainBranchMapUrl,
                                                    class: 'directions-link',
                                                    target: '_blank',
                                                    rel: 'noopener noreferrer'
                                                },
                                                [Fa('Chỉ đường')]
                                            )
                                    ]),
                                    e.otherBranches &&
                                        e.otherBranches.length > 0 &&
                                        La('div', { class: 'branch-info other-branches' }, [
                                            e.otherBranchesTitle && La('h4', null, [e.otherBranchesTitle]),
                                            e.otherBranches.map(function (e, t) {
                                                return La('div', { class: 'branch-item', key: t }, [
                                                    e.name && La('h5', null, [e.name]),
                                                    e.address && La('p', { class: 'address' }, [e.address]),
                                                    e.map_url &&
                                                        La(
                                                            'a',
                                                            {
                                                                href: e.map_url,
                                                                class: 'directions-link',
                                                                target: '_blank',
                                                                rel: 'noopener noreferrer'
                                                            },
                                                            [Fa('Chỉ đường')]
                                                        )
                                                ]);
                                            })
                                        ])
                                ])
                            ])
                        ])
                    ]);
                };
            }
        }),
        xg = to({
            name: 'AskedQuestions',
            props: { title: String, subtitle: String, titleColor: String, subtitleColor: String, items: Array },
            setup: function (e) {
                var t = Jt(null);
                return function () {
                    return La('section', { class: 'asked-questions' }, [
                        La('div', { class: 'container' }, [
                            e.title && La('h2', { class: 'aq-title', style: { color: e.titleColor } }, [e.title]),
                            e.subtitle &&
                                La('p', { class: 'aq-subtitle', style: { color: e.subtitleColor } }, [e.subtitle]),
                            La('div', { class: 'aq-grid' }, [
                                (e.items || []).map(function (e, n) {
                                    return La('div', { class: ['aq-item', { 'is-active': t.value === n }], key: n }, [
                                        La(
                                            'button',
                                            {
                                                class: 'aq-question',
                                                onClick: function () {
                                                    return (function (e) {
                                                        t.value = t.value === e ? null : e;
                                                    })(n);
                                                },
                                                'aria-expanded': t.value === n
                                            },
                                            [
                                                La('span', null, [e.question]),
                                                La('span', { class: 'aq-icon', 'aria-hidden': 'true' }, [
                                                    La(
                                                        'svg',
                                                        {
                                                            class: 'icon-plus',
                                                            width: '20',
                                                            height: '20',
                                                            viewBox: '0 0 24 24',
                                                            fill: 'none',
                                                            xmlns: 'http://www.w3.org/2000/svg'
                                                        },
                                                        [
                                                            La(
                                                                'path',
                                                                {
                                                                    d: 'M12 6V18',
                                                                    stroke: 'currentColor',
                                                                    'stroke-width': '2',
                                                                    'stroke-linecap': 'round',
                                                                    'stroke-linejoin': 'round'
                                                                },
                                                                null
                                                            ),
                                                            La(
                                                                'path',
                                                                {
                                                                    d: 'M6 12H18',
                                                                    stroke: 'currentColor',
                                                                    'stroke-width': '2',
                                                                    'stroke-linecap': 'round',
                                                                    'stroke-linejoin': 'round'
                                                                },
                                                                null
                                                            )
                                                        ]
                                                    ),
                                                    La(
                                                        'svg',
                                                        {
                                                            class: 'icon-x',
                                                            width: '20',
                                                            height: '20',
                                                            viewBox: '0 0 24 24',
                                                            fill: 'none',
                                                            xmlns: 'http://www.w3.org/2000/svg'
                                                        },
                                                        [
                                                            La(
                                                                'path',
                                                                {
                                                                    d: 'M18 6L6 18',
                                                                    stroke: 'currentColor',
                                                                    'stroke-width': '2',
                                                                    'stroke-linecap': 'round',
                                                                    'stroke-linejoin': 'round'
                                                                },
                                                                null
                                                            ),
                                                            La(
                                                                'path',
                                                                {
                                                                    d: 'M6 6L18 18',
                                                                    stroke: 'currentColor',
                                                                    'stroke-width': '2',
                                                                    'stroke-linecap': 'round',
                                                                    'stroke-linejoin': 'round'
                                                                },
                                                                null
                                                            )
                                                        ]
                                                    )
                                                ])
                                            ]
                                        ),
                                        La('div', { class: 'aq-answer-wrapper' }, [
                                            La('div', { class: 'aq-answer' }, [La('p', null, [e.answer])])
                                        ])
                                    ]);
                                })
                            ])
                        ])
                    ]);
                };
            }
        }),
        _g = to({
            name: 'BlogPost',
            props: {
                title: { type: String, default: '' },
                subtitle: { type: String, default: '' },
                categories: { type: Array, required: !0 },
                posts: { type: Array, required: !0 },
                allText: { type: String, default: 'Tất Cả' }
            },
            setup: function (e) {
                var t = Jt(null),
                    n = wl(function () {
                        return null === t.value
                            ? e.posts
                            : e.posts.filter(function (e) {
                                  return e.categories.some(function (e) {
                                      return e.id === t.value;
                                  });
                              });
                    }),
                    r = function (e) {
                        t.value = e;
                    },
                    o = function (e) {
                        return La('div', { class: 'bp-card' }, [
                            La('a', { href: e.url, class: 'bp-card-image-link' }, [
                                La('img', { src: e.image, alt: e.name, loading: 'lazy', decoding: 'async' }, null),
                                e.categories[0] && La('span', { class: 'bp-card-category-tag' }, [e.categories[0].name])
                            ]),
                            La('div', { class: 'bp-card-content' }, [
                                La('h3', { class: 'bp-card-title' }, [La('a', { href: e.url }, [e.name])]),
                                La('p', { class: 'bp-card-description' }, [e.description]),
                                La('div', { class: 'bp-card-meta' }, [
                                    La('div', { class: 'bp-meta-info' }, [
                                        La('span', { class: 'bp-meta-author' }, [e.authorName]),
                                        La('span', { class: 'bp-meta-date' }, [e.createdAt])
                                    ]),
                                    La('a', { href: e.url, class: 'bp-card-arrow' }, [Fa('→')])
                                ])
                            ])
                        ]);
                    };
                return function () {
                    return La('div', { class: 'bp-container' }, [
                        La('header', { class: 'bp-header' }, [
                            e.title && La('h2', { class: 'bp-title' }, [e.title]),
                            e.subtitle && La('p', { class: 'bp-subtitle' }, [e.subtitle]),
                            La('div', { class: 'bp-filters' }, [
                                La(
                                    'button',
                                    {
                                        class: ['bp-filter-btn', null === t.value ? 'active' : ''],
                                        onClick: function () {
                                            return r(null);
                                        }
                                    },
                                    [e.allText]
                                ),
                                e.categories.map(function (e) {
                                    return La(
                                        'button',
                                        {
                                            key: e.id,
                                            class: ['bp-filter-btn', t.value === e.id ? 'active' : ''],
                                            onClick: function () {
                                                return r(e.id);
                                            }
                                        },
                                        [e.name]
                                    );
                                })
                            ])
                        ]),
                        La('div', { class: 'bp-grid' }, [
                            n.value.map(function (e) {
                                return La(o, Ua({ key: e.id }, e), null);
                            })
                        ])
                    ]);
                };
            }
        });
    document.addEventListener('DOMContentLoaded', function () {
        (document.querySelectorAll('[id^="shortcode-banner-page-"]').forEach(function (e) {
            var t = e.getAttribute('data-props');
            if (t)
                try {
                    var n = JSON.parse(t);
                    Sd(Dh, n).mount(e);
                } catch (e) {
                    console.error('Error parsing banner-page props:', e);
                }
        }),
            document.querySelectorAll('[id^="shortcode-banner-for-yard-"]').forEach(function (e) {
                var t = e.getAttribute('data-props');
                if (t)
                    try {
                        var n = JSON.parse(t);
                        Sd(jh, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse banner-for-yard props:', e);
                    }
            }),
            document.querySelectorAll('[id^="shortcode-court-pricing-"]').forEach(function (e) {
                var t = e.dataset.props;
                if (t)
                    try {
                        var n = JSON.parse(t);
                        Sd(Vh, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse court pricing props:', e);
                    }
            }),
            document.querySelectorAll('[id^="shortcode-why-choose-"]').forEach(function (e) {
                var t = e.dataset.props;
                if (t)
                    try {
                        var n = JSON.parse(t);
                        Sd(zh, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse why-choose props:', e);
                    }
            }),
            document.querySelectorAll('[id^="shortcode-testimonials-"]').forEach(function (e) {
                var t = e.dataset.props;
                if (t)
                    try {
                        var n = JSON.parse(t);
                        Sd(gg, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse testimonials props:', e);
                    }
            }));
        var e = document.querySelectorAll('[id^="shortcode-detailed-price-"]');
        (console.log('Found detailed-price containers:', e.length),
            e.forEach(function (e) {
                console.log('Processing container:', e);
                var t = e.dataset.props || e.getAttribute('data-props');
                if ((console.log('Props data:', t), t))
                    try {
                        var n = JSON.parse(t);
                        (console.log('Parsed props:', n), Sd(yg, n).mount(e), console.log('Mounted successfully'));
                    } catch (e) {
                        console.error('Failed to parse detailed-price props:', e);
                    }
                else console.warn('No props data found for container:', e);
            }),
            document.querySelectorAll('.shortcode-why-choose-us').forEach(function (e) {
                var t = e.dataset;
                if (t)
                    try {
                        var n = {
                            title: t.title || '',
                            subtitle: t.subtitle || '',
                            titleColor: t.titleColor || '#0E6B5C',
                            subtitleColor: t.subtitleColor || '#6c757d',
                            tabs: t.tabs || '[]'
                        };
                        Sd(vg, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse why-choose-us props:', e);
                    }
            }));
        var t = document.querySelectorAll('[id^="shortcode-booking-badminton-court-"]');
        (console.log('Found booking-badminton-court containers:', t.length),
            t.forEach(function (e) {
                var t = e.getAttribute('data-props') || e.dataset.props;
                if (t)
                    try {
                        var n = JSON.parse(t);
                        (console.log('Parsed booking props:', n), Sd(bg, n).mount(e));
                    } catch (e) {
                        console.error('Failed to parse booking-badminton-court props:', e);
                    }
                else console.warn('No props data found for booking container:', e);
            }),
            document.querySelectorAll('[id^="shortcode-select-membership-"]').forEach(function (e) {
                var t = e.getAttribute('data-props');
                if (t)
                    try {
                        var n = JSON.parse(t);
                        Sd(wg, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse select-membership props:', e);
                    }
            }),
            document.querySelectorAll('[id^="shortcode-asked-questions-"]').forEach(function (e) {
                var t = e.getAttribute('data-props');
                if (t)
                    try {
                        var n = JSON.parse(t);
                        Sd(xg, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse asked-questions props:', e);
                    }
            }),
            document.querySelectorAll('[id^="shortcode-blog-post-"]').forEach(function (e) {
                var t = e.getAttribute('data-props');
                if (t)
                    try {
                        var n = JSON.parse(t);
                        Sd(_g, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse blog-post props:', e);
                    }
            }),
            document.querySelectorAll('[id^="shortcode-contact-us-"]').forEach(function (e) {
                var t = e.getAttribute('data-props');
                if (t)
                    try {
                        var n = JSON.parse(t);
                        Sd(Sg, n).mount(e);
                    } catch (e) {
                        console.error('Failed to parse contact-us props:', e);
                    }
            }));
        var n = ['đặt sân', 'dat san', 'bắt đầu ngay', 'bat dau ngay'],
            r = document.querySelectorAll('a, button');
        console.log('[Debug] Found '.concat(r.length, ' potential CTA buttons.'));
        var o = function (e) {
            try {
                if (e.startsWith('/')) return e;
                var t = new URL(e, window.location.origin);
                return t.pathname + t.search + t.hash;
            } catch (t) {
                return e;
            }
        };
        r.forEach(function (e) {
            var t = (e.textContent || '').trim().toLowerCase();
            n.some(function (e) {
                return t.includes(e);
            }) &&
                (console.log('[Debug] Found CTA button:', e),
                e.addEventListener('click', function (e) {
                    var t,
                        n = e.currentTarget;
                    if (n instanceof HTMLAnchorElement) {
                        var r = (n.getAttribute('href') || '').trim();
                        if (r && '#' !== r && !r.toLowerCase().startsWith('javascript:')) return;
                    }
                    var i = (
                        n.getAttribute('data-href') ||
                        n.getAttribute('data-url') ||
                        n.getAttribute('data-link') ||
                        ''
                    ).trim();
                    if (i && '#' !== i && !i.toLowerCase().startsWith('javascript:')) {
                        e.preventDefault();
                        var s = o(i);
                        return (
                            console.log('[CTA Fallback] Navigating to (data-*): '.concat(s)),
                            void window.location.assign(s)
                        );
                    }
                    e.preventDefault();
                    var a =
                            window.BOOKING_URL ||
                            (null === (t = window.App) || void 0 === t ? void 0 : t.bookingUrl) ||
                            '/dat-san',
                        l = o(String(a));
                    (console.log('[CTA Fallback] Navigating to (fallback): '.concat(l)), window.location.assign(l));
                }));
        });
    });
})();
