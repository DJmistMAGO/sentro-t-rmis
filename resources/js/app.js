import "./bootstrap";
import Alpine from "alpinejs";

$(document).ready(function () {
    window.Alpine = Alpine;
    Alpine.start();

    $(document).on("click", "[data-add-item]", function () {
        let _container = $(this).closest("[data-item-container]");
        if (_container) {
            let _template = _container.find("[data-parent]").first();
            if (_template) {
                let clone = _template.clone();
                $(clone)
                    .find(".row")
                    .each((index, item) => {
                        let attr = $(item).attr("data-parent");
                        if (typeof attr === "undefined" || attr === false) {
                            $(item).remove();
                        }
                    });
                if ($(clone[0]).attr("data-parent") !== undefined) {
                    $(clone[0]).removeAttr("data-parent");
                    $(clone[0])
                        .find("[data-item-hide]")
                        .first()
                        .removeClass("d-none");
                    $(clone[0])
                        .find("input, select")
                        .each(function (index, item) {
                            item.value = "";
                        });
                    _container.append($(clone[0]));
                }
            }
        }
    });

    
    $(document).on("click", "[data-remove-item]", function () {
        let _parent = $(this).closest(".row");
        _parent.remove();
    });
    
    // data-calc-item => assign to input text that you want to include in sum
    // data-calc-total => assign to input for displaying the total
    $(document).on("change", "[data-calc-item]", function () {
        let _total_text = $("[data-calc-total]");
        if (_total_text) {
            let allItems = $("[data-calc-item]");
            let total = 0;
            allItems.each(function (index, item) {
                let _this = $(item);
                if (!isNaN(_this.val()) && _this.val() !== "") {
                    let val = _this.val();
                    total += parseFloat(val);
                }
            });
            _total_text.val("Php. " + total);
        }
    });
});
