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