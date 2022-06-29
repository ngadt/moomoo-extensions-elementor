(function($){
    $(window).on('elementor/frontend/init', () => {
    	
    	function moomooCalculateStampDuty($element){   
    		 var modules = {};

		    window.addEventListener('load', function () {			    	   	
		        modules.StampDutyCalculator = new KfCommon.StampDutyCalculatorNew();
		    });
		    var NumberFormat = (function () {
			    function e() {}
			    return (
			        (e.onDocumentReady = function () {
			            e.priceFormat();
			        }),
			        (e.priceFormat = function () {
			            $(".js-price-format").each(function () {
			                $(this).on("keyup", function (e) {
			                    75 == e.keyCode ? $(this).val($(this).val() + "000") : 77 == e.keyCode ? $(this).val($(this).val() + "000000") : 66 == e.keyCode && $(this).val($(this).val() + "000000000");
			                    var t = $(this).val(),
			                        t = t.replace(/[\D\s\._\-]+/g, ""),
			                        i = t ? parseInt(t, 10) : 0;
			                    $(this).val(function () {
			                        return 0 === i ? "" : i.toLocaleString("en-US");
			                    });
			                });
			            });
			        }),
			        (e.numberClean = function (e) {
			            if ("" === e) i = 0;
			            else
			                var t = e.replace(/,/g, ""),
			                    i = parseInt(t);
			            return i;
			        }),
			        e
			    );
			})();
			$(document).ready(NumberFormat.onDocumentReady);
			//calculate	
			var KfCommon;
			!(function (e) {    
			    var i = (function () {
			        function e() {			        	
			            var e = this;
			            (this.calcBands = [
			                { min: 0, max: 125e3, pct: 0 },
			                { min: 125e3, max: 25e4, pct: 0.02 },
			                { min: 25e4, max: 925e3, pct: 0.05 },
			                { min: 925e3, max: 15e5, pct: 0.1 },
			                { min: 15e5, max: null, pct: 0.12 },
			            ]),
			                (this.calcBands2ndHome = [
			                    { min: 0, max: 125e3, pct: 0.03 },
			                    { min: 125e3, max: 25e4, pct: 0.05 },
			                    { min: 25e4, max: 925e3, pct: 0.08 },
			                    { min: 925e3, max: 15e5, pct: 0.13 },
			                    { min: 15e5, max: null, pct: 0.15 },
			                ]),
			                (this.calcBandsCovid2 = [
			                    { min: 0, max: 25e4, pct: 0 },
			                    { min: 25e4, max: 925e3, pct: 0.05 },
			                    { min: 925e3, max: 15e5, pct: 0.1 },
			                    { min: 15e5, max: null, pct: 0.12 },
			                ]),
			                (this.calcBandsCovid22ndHome = [
			                    { min: 0, max: 25e4, pct: 0.03 },
			                    { min: 25e4, max: 925e3, pct: 0.08 },
			                    { min: 925e3, max: 15e5, pct: 0.13 },
			                    { min: 15e5, max: null, pct: 0.15 },
			                ]),
			                (this.calcBandsNA = [{ min: 0, max: 39999, pct: 0 }]),
			                (this.calcBands1stHome = [
			                    { min: 0, max: 3e5, pct: 0 },
			                    { min: 3e5, max: 5e5, pct: 0.05 },
			                ]),
			                (this.calcBandsOverseas = [
			                    { min: 0, max: 125e3, pct: 0.02 },
			                    { min: 125e3, max: 25e4, pct: 0.04 },
			                    { min: 25e4, max: 925e3, pct: 0.07 },
			                    { min: 925e3, max: 15e5, pct: 0.12 },
			                    { min: 15e5, max: null, pct: 0.14 },
			                ]),
			                (this.calcBandsOverseas1stHome = [
			                    { min: 0, max: 3e5, pct: 0.02 },
			                    { min: 3e5, max: 5e5, pct: 0.07 },
			                ]),
			                (this.calcBandsOverseas2ndHome = [
			                    { min: 0, max: 125e3, pct: 0.05 },
			                    { min: 125e3, max: 25e4, pct: 0.07 },
			                    { min: 25e4, max: 925e3, pct: 0.1 },
			                    { min: 925e3, max: 15e5, pct: 0.15 },
			                    { min: 15e5, max: null, pct: 0.17 },
			                ]),
			                (this.calcBandsOverseasNA = [{ min: 0, max: 39999, pct: 0.02 }]),
			                (this.calcBandsCovidOverseas = [
			                    { min: 0, max: 5e5, pct: 0.02 },
			                    { min: 5e5, max: 925e3, pct: 0.07 },
			                    { min: 925e3, max: 15e5, pct: 0.12 },
			                    { min: 15e5, max: null, pct: 0.14 },
			                ]),
			                (this.calcBandsCovidOverseas2ndHome = [
			                    { min: 0, max: 5e5, pct: 0.05 },
			                    { min: 5e5, max: 925e3, pct: 0.1 },
			                    { min: 925e3, max: 15e5, pct: 0.15 },
			                    { min: 15e5, max: null, pct: 0.17 },
			                ]),
			                (this.calcBandsCovid2Overseas = [
			                    { min: 0, max: 25e4, pct: 0.02 },
			                    { min: 25e4, max: 925e3, pct: 0.07 },
			                    { min: 925e3, max: 15e5, pct: 0.12 },
			                    { min: 15e5, max: null, pct: 0.14 },
			                ]),
			                (this.calcBandsCovid2Overseas2ndHome = [
			                    { min: 0, max: 25e4, pct: 0.05 },
			                    { min: 25e4, max: 925e3, pct: 0.1 },
			                    { min: 925e3, max: 15e5, pct: 0.15 },
			                    { min: 15e5, max: null, pct: 0.17 },
			                ]),
			                (this.rowTemplate = "<tr><td>{taxband}</td><td>{pct}</td><td>{taxablesum}</td><td>{tax}</td></tr>"),
			                $("#secondHomeNew").on("click", function () {
			                    $("#firstHomeNew").prop("checked", !1);
			                }),
			                $("#firstHomeNew").on("click", function () {
			                    $("#secondHomeNew").prop("checked", !1);
			                }),
			                $(".js-stamp-duty-calculate").on("click", function () {
			                    e.calculateStampDutyNew();
			                }),
			                $("#clear-stampNew").click(function () {
			                    $("#divResultNew").fadeOut(), $("#priceNew").val("");
			                });
			        }
			        return (
			            (e.prototype.format = function (e, t, i, n, s) {
			                var o = "\\d(?=(\\d{" + (i || 3) + "})+" + (t > 0 ? "\\D" : "$") + ")",
			                    a = e.toFixed(Math.max(0, ~~t));
			                return (s ? a.replace(".", s) : a).replace(new RegExp(o, "g"), "$&" + (n || ","));
			            }),
			            (e.prototype.calculateStampDutyNew = function () {
			            
			        		 
			                var e = this.calcBands,
			                    t = NumberFormat.numberClean($("#priceNew").val()),
			                    calculate_unit_currency = $('.calculator input#calculate_unit_currency').val()+ ' ';

			                $("#secondHomeNew").is(":checked") && ((e = this.calcBands2ndHome), t < 4e4 && (e = this.calcBandsNA)),
			                    $("#firstHomeNew").is(":checked") && ((e = this.calcBands1stHome), t > 5e5 && (e = this.calcBands)),
			                    "covid2" === $("#select-date").children("option:selected").val() &&
			                        ((e = this.calcBandsCovid2),
			                        $("#firstHomeNew").is(":checked") && ((e = this.calcBands1stHome), t > 5e5 && (e = this.calcBandsCovid2)),
			                        $("#secondHomeNew").is(":checked") && ((e = this.calcBandsCovid22ndHome), t < 4e4 && (e = this.calcBandsNA))),
			                    $("#overseasBuyer").is(":checked") &&
			                        ((e = this.calcBandsOverseas),
			                        $("#secondHomeNew").is(":checked") && ((e = this.calcBandsOverseas2ndHome), t < 4e4 && (e = this.calcBandsOverseasNA)),
			                        $("#firstHomeNew").is(":checked") && ((e = this.calcBandsOverseas1stHome), t > 5e5 && (e = this.calcBandsOverseas)),
			                        "covid" === $("#select-date").children("option:selected").val() &&
			                            ((e = this.calcBandsCovidOverseas),
			                            $("#secondHomeNew").is(":checked") && ((e = this.calcBandsCovidOverseas2ndHome), t < 4e4 && (e = this.calcBandsOverseasNA)),
			                            $("#firstHomeNew").is(":checked") && ((e = this.calcBandsOverseas1stHome), t > 5e5 && (e = this.calcBandsCovidOverseas))),
			                        "covid2" === $("#select-date").children("option:selected").val() &&
			                            ((e = this.calcBandsCovid2Overseas),
			                            $("#firstHomeNew").is(":checked") && ((e = this.calcBandsOverseas1stHome), t > 5e5 && (e = this.calcBandsCovid2Overseas)),
			                            $("#secondHomeNew").is(":checked") && ((e = this.calcBandsCovid2Overseas2ndHome), t < 4e4 && (e = this.calcBandsOverseasNA)))),
			                    $(".stamp-error").fadeOut(),
			                    $("#resultTableNew").length && $("#resultTableNew").find("tr:gt(0)").remove();
			                for (var i = e.length, n = 0, s = 0; s < i; ++s) {
			                	
			                    var o = e[s],
			                        a = t,
			                        r = this.rowTemplate;
			                    null != o.max
			                        ? ((a = Math.min(o.max, a)), (r = r.replace("{taxband}", calculate_unit_currency + this.format(o.min, 0, 3, ",", ".") + " - £" + this.format(o.max, 0, 3, ",", "."))))
			                        : (r = r.replace("{taxband}", calculate_unit_currency + this.format(o.min, 0, 3, ",", ".") + "+"));
			                    var l = Math.max(0, a - o.min),
			                        c = l * o.pct;
			                    n += c;
			                    var h = Number((100 * o.pct).toFixed(0));
			                    (r = r.replace("{pct}", h + "%")),
			                        (r = r.replace("{taxablesum}", calculate_unit_currency + this.format(l, 0, 3, ",", "."))),
			                        (r = r.replace("{tax}", calculate_unit_currency + this.format(c, 2, 3, ",", "."))),
			                        $("#resultTableNew").length && $("#resultTableNew tr:last").after(r);
			                }
			                var d = 0;
			                0 != t && (d = n / t), $("#amountToPayNew").text(calculate_unit_currency + this.format(n, 2, 3, ",", ".")), $("#effectiveRateNew").text((100 * d).toFixed(1) + "%"), $("#divResultNew").fadeIn();
			            }),
			            e
			        );
			    })();
			    e.StampDutyCalculatorNew = i;
			})(KfCommon || (KfCommon = {}));
			var __extends =
			        (this && this.__extends) ||
			        (function () {
			            var e =
			                Object.setPrototypeOf ||
			                ({ __proto__: [] } instanceof Array &&
			                    function (e, t) {
			                        e.__proto__ = t;
			                    }) ||
			                function (e, t) {
			                    for (var i in t) t.hasOwnProperty(i) && (e[i] = t[i]);
			                };
			            return function (t, i) {
			                function n() {
			                    this.constructor = t;
			                }
			                e(t, i), (t.prototype = null === i ? Object.create(i) : ((n.prototype = i.prototype), new n()));
			            };
			        })(),
			    KfCommon;
			!(function (e) {
			    var t = (function () {
			            function e(e) {
			                var t = this;
			                (this.rowTemplate = "<tr><td>{taxband}</td><td>{pct}</td><td>{taxablesum}</td><td>{tax}</td></tr>"),
			                    (this.selector = e),
			                    $(this.selector).find(".calculator-results").hide(),
			                    $(this.selector).find(".error").hide(),
			                    $(e)
			                        .find(".calculator-price")
			                        .keyup(function (e) {
			                            t.calculate();
			                        }),
			                    $(e)
			                        .find(".calculator-price")
			                        .on("change", function () {
			                            t.calculate();
			                        }),
			                    $(e)
			                        .find(".checkbox")
			                        .on("click", function () {
			                            t.calculate();
			                        });
			            }
			            return (
			                (e.prototype.calculate = function () {
			                    var e = this.getBands();
			                    $(".error").fadeOut(), $(this.selector).find(".calculator-results-table").length && $(this.selector).find(".calculator-results-table").find("tr:gt(0)").remove();
			                    for (var t = NumberFormat.numberClean($(".calculator-price").val()), i = 0, n = 0; n < e.length; ++n) i += this.addResultBand(t, e[n]);
			                    var s = 0;
			                    0 != t && (s = i / t),
			                        $(this.selector)
			                            .find(".calculator-amount-to-pay")
			                            .text(calculate_unit_currency + this.format(i, 2, 3, ",", ".")),
			                        $(this.selector)
			                            .find(".calculator-effective-new-rate")
			                            .text((100 * s).toFixed(1) + "%"),
			                        $(this.selector).find(".calculator-results").fadeIn();
			                }),
			                (e.prototype.addResultBand = function (e, t) {
			                    var i = e,
			                        n = this.rowTemplate;
			                    null != t.max
			                        ? ((i = Math.min(t.max, i)), (n = n.replace("{taxband}", calculate_unit_currency + this.format(t.min, 0, 3, ",", ".") + " - £" + this.format(t.max, 0, 3, ",", "."))))
			                        : (n = n.replace("{taxband}", calculate_unit_currency + this.format(t.min, 0, 3, ",", ".") + "+"));
			                    var s = Math.max(0, i - t.min),
			                        o = s * t.pct,
			                        a = 100 * Number(t.pct);
			                    return (
			                        (n = n.replace("{pct}", a.toFixed(0) + "%")),
			                        (n = n.replace("{taxablesum}", calculate_unit_currency + this.format(s, 0, 3, ",", "."))),
			                        (n = n.replace("{tax}", calculate_unit_currency + this.format(o, 2, 3, ",", "."))),
			                        $(this.selector).find(".calculator-results-table").length && $(this.selector).find(".calculator-results-table tr:last").after(n),
			                        o
			                    );
			                }),
			                (e.prototype.format = function (e, t, i, n, s) {
			                    var o = "\\d(?=(\\d{" + (i || 3) + "})+" + (t > 0 ? "\\D" : "$") + ")",
			                        a = e.toFixed(Math.max(0, ~~t));
			                    return (s ? a.replace(".", s) : a).replace(new RegExp(o, "g"), "$&" + (n || ","));
			                }),
			                e
			            );
			        })(),
			        i = (function (e) {
			            function t() {
			                var t = (null !== e && e.apply(this, arguments)) || this;
			                return (
			                    (t.calcBands = [
			                        { min: 0, max: 145e3, pct: 0 },
			                        { min: 145e3, max: 25e4, pct: 0.02 },
			                        { min: 25e4, max: 325e3, pct: 0.05 },
			                        { min: 325e3, max: 75e4, pct: 0.1 },
			                        { min: 75e4, max: null, pct: 0.12 },
			                    ]),
			                    (t.buyToLetBands = [
			                        { min: 0, max: 145e3, pct: 0.04 },
			                        { min: 145e3, max: 25e4, pct: 0.06 },
			                        { min: 25e4, max: 325e3, pct: 0.09 },
			                        { min: 325e3, max: 75e4, pct: 0.14 },
			                        { min: 75e4, max: null, pct: 0.16 },
			                    ]),
			                    t
			                );
			            }
			            return (
			                __extends(t, e),
			                (t.prototype.getBands = function () {
			                    return $(this.selector).find(".calculator-but-to-let").is(":checked") ? this.buyToLetBands : this.calcBands;
			                }),
			                t
			            );
			        })(t);
			    e.ResidentialLbttCalculator = i;
			    var n = (function (e) {
			        function t() {
			            var t = (null !== e && e.apply(this, arguments)) || this;
			            return (
			                (t.bands = [
			                    { min: 0, max: 15e4, pct: 0 },
			                    { min: 15e4, max: 25e4, pct: 0.02 },
			                    { min: 25e4, max: null, pct: 0.05 },
			                ]),
			                t
			            );
			        }
			        return (
			            __extends(t, e),
			            (t.prototype.getBands = function () {
			                return this.bands;
			            }),
			            t
			        );
			    })(t);
			    e.ComercialSdltCalculator = n;
			    var s = (function (e) {
			        function t() {
			            var t = (null !== e && e.apply(this, arguments)) || this;
			            return (
			                (t.bands = [
			                    { min: 0, max: 15e4, pct: 0 },
			                    { min: 15e4, max: 25e4, pct: 0.01 },
			                    { min: 25e4, max: null, pct: 0.05 },
			                ]),
			                t
			            );
			        }
			        return (
			            __extends(t, e),
			            (t.prototype.getBands = function () {
			                return this.bands;
			            }),
			            t
			        );
			    })(t);
			    e.CommercialLbttCalculator = s;
			})(KfCommon || (KfCommon = {}));
	   };
	  
      
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-calculate-stamp-duty.default', moomooCalculateStampDuty);
    });
})(jQuery)

