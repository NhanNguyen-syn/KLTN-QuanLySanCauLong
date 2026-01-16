(() => {
    'use strict';
    function n() {
        /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e,
            r,
            a = 'function' == typeof Symbol ? Symbol : {},
            o = a.iterator || '@@iterator',
            i = a.toStringTag || '@@toStringTag';
        function c(n, a, o, i) {
            var c = a && a.prototype instanceof d ? a : d,
                l = Object.create(c.prototype);
            return (
                t(
                    l,
                    '_invoke',
                    (function (n, t, a) {
                        var o,
                            i,
                            c,
                            d = 0,
                            l = a || [],
                            u = !1,
                            v = {
                                p: 0,
                                n: 0,
                                v: e,
                                a: p,
                                f: p.bind(e, 4),
                                d: function (n, t) {
                                    return ((o = n), (i = 0), (c = e), (v.n = t), s);
                                }
                            };
                        function p(n, t) {
                            for (i = n, c = t, r = 0; !u && d && !a && r < l.length; r++) {
                                var a,
                                    o = l[r],
                                    p = v.p,
                                    f = o[2];
                                n > 3
                                    ? (a = f === t) && ((c = o[(i = o[4]) ? 5 : ((i = 3), 3)]), (o[4] = o[5] = e))
                                    : o[0] <= p &&
                                      ((a = n < 2 && p < o[1])
                                          ? ((i = 0), (v.v = t), (v.n = o[1]))
                                          : p < f &&
                                            (a = n < 3 || o[0] > t || t > f) &&
                                            ((o[4] = n), (o[5] = t), (v.n = f), (i = 0)));
                            }
                            if (a || n > 1) return s;
                            throw ((u = !0), t);
                        }
                        return function (a, l, f) {
                            if (d > 1) throw TypeError('Generator is already running');
                            for (u && 1 === l && p(l, f), i = l, c = f; (r = i < 2 ? e : c) || !u; ) {
                                o || (i ? (i < 3 ? (i > 1 && (v.n = -1), p(i, c)) : (v.n = c)) : (v.v = c));
                                try {
                                    if (((d = 2), o)) {
                                        if ((i || (a = 'next'), (r = o[a]))) {
                                            if (!(r = r.call(o, c)))
                                                throw TypeError('iterator result is not an object');
                                            if (!r.done) return r;
                                            ((c = r.value), i < 2 && (i = 0));
                                        } else
                                            (1 === i && (r = o.return) && r.call(o),
                                                i < 2 &&
                                                    ((c = TypeError(
                                                        "The iterator does not provide a '" + a + "' method"
                                                    )),
                                                    (i = 1)));
                                        o = e;
                                    } else if ((r = (u = v.n < 0) ? c : n.call(t, v)) !== s) break;
                                } catch (n) {
                                    ((o = e), (i = 1), (c = n));
                                } finally {
                                    d = 1;
                                }
                            }
                            return { value: r, done: u };
                        };
                    })(n, o, i),
                    !0
                ),
                l
            );
        }
        var s = {};
        function d() {}
        function l() {}
        function u() {}
        r = Object.getPrototypeOf;
        var v = [][o]
                ? r(r([][o]()))
                : (t((r = {}), o, function () {
                      return this;
                  }),
                  r),
            p = (u.prototype = d.prototype = Object.create(v));
        function f(n) {
            return (
                Object.setPrototypeOf ? Object.setPrototypeOf(n, u) : ((n.__proto__ = u), t(n, i, 'GeneratorFunction')),
                (n.prototype = Object.create(p)),
                n
            );
        }
        return (
            (l.prototype = u),
            t(p, 'constructor', u),
            t(u, 'constructor', l),
            (l.displayName = 'GeneratorFunction'),
            t(u, i, 'GeneratorFunction'),
            t(p),
            t(p, i, 'Generator'),
            t(p, o, function () {
                return this;
            }),
            t(p, 'toString', function () {
                return '[object Generator]';
            }),
            (n = function () {
                return { w: c, m: f };
            })()
        );
    }
    function t(n, e, r, a) {
        var o = Object.defineProperty;
        try {
            o({}, '', {});
        } catch (n) {
            o = 0;
        }
        ((t = function (n, e, r, a) {
            function i(e, r) {
                t(n, e, function (n) {
                    return this._invoke(e, r, n);
                });
            }
            e
                ? o
                    ? o(n, e, { value: r, enumerable: !a, configurable: !a, writable: !a })
                    : (n[e] = r)
                : (i('next', 0), i('throw', 1), i('return', 2));
        }),
            t(n, e, r, a));
    }
    function e(n, t, e, r, a, o, i) {
        try {
            var c = n[o](i),
                s = c.value;
        } catch (n) {
            return void e(n);
        }
        c.done ? t(s) : Promise.resolve(s).then(r, a);
    }
    function r(n) {
        return function () {
            var t = this,
                r = arguments;
            return new Promise(function (a, o) {
                var i = n.apply(t, r);
                function c(n) {
                    e(i, a, o, c, s, 'next', n);
                }
                function s(n) {
                    e(i, a, o, c, s, 'throw', n);
                }
                c(void 0);
            });
        };
    }
    var a = {
        processing: { label: 'Đang xử lý', cls: 'badge badge--blue' },
        pending: { label: 'Chờ thanh toán', cls: 'badge badge--blue' },
        paid: { label: 'Đã thanh toán', cls: 'badge badge--green' },
        completed: { label: 'Hoàn thành', cls: 'badge badge--green' },
        cancelled: { label: 'Đã hủy', cls: 'badge badge--red' },
        refunded: { label: 'Hoàn tiền', cls: 'badge badge--amber' }
    };
    function o(n) {
        try {
            return n.toLocaleString('vi-VN') + 'đ';
        } catch (t) {
            return ''.concat(n, 'đ');
        }
    }
    function i(n) {
        return document.getElementById(n);
    }
    function c(n) {
        return s.apply(this, arguments);
    }
    function s() {
        return (s = r(
            n().m(function t(e) {
                var r, a, o;
                return n().w(function (n) {
                    for (;;)
                        switch (n.n) {
                            case 0:
                                return (
                                    (r = '/api/court-booking/lookup?order_code='.concat(encodeURIComponent(e))),
                                    (n.n = 1),
                                    fetch(r, { headers: { Accept: 'application/json' } })
                                );
                            case 1:
                                return (
                                    (a = n.v),
                                    (n.n = 2),
                                    a.json().catch(function () {
                                        return null;
                                    })
                                );
                            case 2:
                                if (((o = n.v), a.ok)) {
                                    n.n = 3;
                                    break;
                                }
                                return n.a(2, {
                                    success: !1,
                                    message: (null == o ? void 0 : o.message) || 'NOT_FOUND'
                                });
                            case 3:
                                return n.a(2, o);
                        }
                }, t);
            })
        )).apply(this, arguments);
    }
    function d(n) {
        var t = i('lookup-result');
        t &&
            ((t.hidden = !1),
            (t.innerHTML =
                '\n    <div class="lookup-card lookup-card--empty">\n      <div class="empty-icon">✕</div>\n      <h3>Không tìm thấy</h3>\n      <p>Mã hóa đơn <strong>'.concat(
                    n,
                    '</strong> không tồn tại trong hệ thống.</p>\n      <div class="empty-hint">Vui lòng kiểm tra lại hoặc liên hệ hotline.</div>\n    </div>\n  '
                )));
    }
    function l(n) {
        var t = i('lookup-result');
        if (t) {
            var e = a[n.status] || { label: n.status, cls: 'badge badge--gray' },
                r = (n.items || [])
                    .map(function (n) {
                        return '\n      <div class="item-row">\n        <div class="item-main">\n          <div class="item-title">'
                            .concat(n.court_name || 'Sân', '</div>\n          <div class="item-sub">')
                            .concat(n.date, ' • ')
                            .concat(n.start_time, ' - ')
                            .concat(
                                n.end_time,
                                '</div>\n        </div>\n        <div class="item-side">\n          <div class="item-price">'
                            )
                            .concat(o(Number(n.price || 0)), '</div>\n          <div class="item-paid">Đã cọc: ')
                            .concat(o(Number(n.paid_amount || 0)), '</div>\n        </div>\n      </div>\n    ');
                    })
                    .join('');
            ((t.hidden = !1),
                (t.innerHTML =
                    '\n    <div class="lookup-card">\n      <div class="lookup-card__head">\n        <div>\n          <div class="code">Mã hóa đơn: <strong>'
                        .concat(n.order_code, '</strong></div>\n          <div class="meta">Cập nhật: ')
                        .concat(n.updated_at || '', '</div>\n        </div>\n        <div class="')
                        .concat(e.cls, '">')
                        .concat(
                            e.label,
                            '</div>\n      </div>\n\n      <div class="lookup-card__body">\n        <div class="grid">\n          <div class="panel">\n            <div class="panel__title">Thông tin đơn</div>\n            <div class="kv"><span>Khách hàng</span><span>'
                        )
                        .concat(
                            n.customer_name || '—',
                            '</span></div>\n            <div class="kv"><span>Liên hệ</span><span>'
                        )
                        .concat(
                            n.contact || '—',
                            '</span></div>\n            <div class="kv"><span>Ghi chú</span><span>'
                        )
                        .concat(
                            n.notes || '—',
                            '</span></div>\n          </div>\n\n          <div class="panel">\n            <div class="panel__title">Tổng tiền</div>\n            <div class="total">\n              <div class="total__row"><span>Tổng giá</span><strong>'
                        )
                        .concat(
                            o(Number(n.total_price || 0)),
                            '</strong></div>\n              <div class="total__row"><span>Đã cọc</span><strong>'
                        )
                        .concat(
                            o(Number(n.total_paid || 0)),
                            '</strong></div>\n            </div>\n          </div>\n        </div>\n\n        <div class="panel panel--list">\n          <div class="panel__title">Chi tiết sân</div>\n          '
                        )
                        .concat(r, '\n        </div>\n      </div>\n    </div>\n  ')));
        }
    }
    function u(n) {
        var t = i('lookup-btn'),
            e = i('order-code');
        if (t) {
            t.disabled = n || !((null == e ? void 0 : e.value) || '').trim();
            var r = t.querySelector('.lookup-btn__text');
            r && (r.textContent = n ? 'Đang tìm...' : 'Tra cứu');
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        var t = i('order-code'),
            e = i('lookup-btn');
        if (t && e) {
            var a = (function () {
                var e = r(
                    n().m(function e() {
                        var r, a;
                        return n().w(function (n) {
                            for (;;)
                                switch (n.n) {
                                    case 0:
                                        if (((r = (t.value || '').trim().toUpperCase()), (t.value = r), r)) {
                                            n.n = 1;
                                            break;
                                        }
                                        return n.a(2);
                                    case 1:
                                        return (u(!0), (n.n = 2), c(r));
                                    case 2:
                                        if (((a = n.v), u(!1), a.success)) {
                                            n.n = 3;
                                            break;
                                        }
                                        return (d(r), n.a(2));
                                    case 3:
                                        l(a.data);
                                    case 4:
                                        return n.a(2);
                                }
                        }, e);
                    })
                );
                return function () {
                    return e.apply(this, arguments);
                };
            })();
            (t.addEventListener('input', function () {
                e.disabled = !(t.value || '').trim();
            }),
                t.addEventListener('keydown', function (n) {
                    'Enter' === n.key && a();
                }),
                e.addEventListener('click', a));
        }
    });
})();
