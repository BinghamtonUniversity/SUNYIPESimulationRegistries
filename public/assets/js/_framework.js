$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';
$.fn.modal.prototype.constructor.Constructor.DEFAULTS.keyboard =  false;

window.app = {
    data:{current_year:new Date().getFullYear()},
    update:{},
    forms:{},
}
window.templates = {
    main:'',
}
window.forms = [];

window.ractive = Ractive({
    target: '#main_target',
    template: window.templates.main,
    partials: window.templates,
    data: app.data
});

app.update = function(newdata) {
    if (typeof newdata !== 'undefined') {
        for (new_data_key in newdata) {
            app.data[new_data_key] = newdata[new_data_key]
        }
    } 
    window.ractive.set(app.data)
    for (data_key in app.data) {
        gform.collections.update(data_key, app.data[data_key])
    }
};

app.get = function(url,callback_success,callback_error) {
    $.ajax({
        type: "GET",
        url: url,
        success:function(data) {
            if (typeof callback_success !== 'undefined') {callback_success(data);}
        },
        error:function(data) {
            if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.error !== 'undefined') {
                toastr.error(data.responseJSON.error)
            } else if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.message !== 'undefined') {
                toastr.error(data.responseJSON.message)
            }
            if (typeof callback_error !== 'undefined') {callback_error(data);}
        }
    });
}
app.post = function(url,data,callback_success,callback_error) {
    $.ajax({
        type: "POST",
        url: url,
        contentType: "application/json",
        data: JSON.stringify(data),
        success:function(data) {
            toastr.success("Created Successfully")
            if (typeof callback_success !== 'undefined') {callback_success(data);}
        },
        error:function(data) {
            toastr.error("An Error Occurred During Creation")
            if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.error !== 'undefined') {
                toastr.error(data.responseJSON.error)
            } else if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.message !== 'undefined') {
                toastr.error(data.responseJSON.message)
            }
            if (typeof callback_error !== 'undefined') {callback_error(data);}
        }
    });
}
app.put = function(url,data,callback_success,callback_error) {
    $.ajax({
        type: "PUT",
        url: url,
        contentType: "application/json",
        data: JSON.stringify(data),
        success:function(data) {
            toastr.success("Updated Sucessfully")
            if (typeof callback_success !== 'undefined') {callback_success(data);}
        },
        error:function(data) {
            toastr.error("An Error Occurred During Update")
            if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.error !== 'undefined') {
                toastr.error(data.responseJSON.error)
            } else if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.message !== 'undefined') {
                toastr.error(data.responseJSON.message)
            }
            if (typeof callback_error !== 'undefined') {callback_error(data);}
        }
    });
}
app.delete = function(url,data,callback_success,callback_error) {
    $.ajax({
        type: "DELETE",
        url: url,
        contentType: "application/json",
        data: JSON.stringify(data),
        success:function(data) {
            toastr.success("Deleted Sucessfully")
            if (typeof callback_success !== 'undefined') {callback_success(data);}
        },
        error:function(data) {
            toastr.error("An Error Occurred During Deletion")
            if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.error !== 'undefined') {
                toastr.error(data.responseJSON.error)
            } else if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.message !== 'undefined') {
                toastr.error(data.responseJSON.message)
            }
            if (typeof callback_error !== 'undefined') {callback_error(data);}
        }
    });
}

app.fetch = function(callback) {
    app.get('config.php',{},function(resp_data){
        app.update(resp_data);
        callback();
    })
}

app.findForm = function(form_name) {
    if (typeof window.forms[form_name] !== 'undefined') {
        return window.forms[form_name]
    } else {
        return null;
    }
}

app.form = function(form_name,target) {
    if (_.has(app.forms,form_name)) {
        return app.forms[form_name];
    }
    form_definition = app.findForm(form_name);
    if (form_definition !== null) {
        if (typeof target !== 'undefined') {
            app.forms[form_name] = new gform(form_definition,target) 
            return app.forms[form_name];  
        } else {
            app.forms[form_name] = new gform(form_definition)
            return app.forms[form_name];
        }
    } else {
        return null;
    }
}

app.render = function(template_name, data) {
    var local_ractive = Ractive({
        template: window.templates[template_name],
        partials: window.templates,
        data: data
    });
    return local_ractive.toHTML();
}

toastr.options = {
    "positionClass": "toast-bottom-right",
    "timeOut": "10000",
}

app.alert = function(config) {
    if (typeof config === 'string') {
        toastr.info(config)
    } else {
        if (typeof config.status === 'undefined') {
            config.status = 'success'
        }
        if (typeof config.title === 'undefined') {
            config.title = ''
        }
        if (typeof config.content === 'undefined') {
            config.content = ''
        }
        toastr[config.status](config.title, config.content)
    }
}

$('#app-modal').on('hide.bs.modal', function (e) {
    app.data._modal.content = '';
    app.update();
})

app.modal = function(config,callback) {
    if (typeof config === 'string') {
        app.data._modal.title = '';
        app.data._modal.content = config;
    } else {
        app.data._modal = config;
        if (typeof app.data._modal.title === 'undefined') {
            app.data._modal.title = '';
        }
        if (typeof app.data._modal.content === 'undefined') {
            app.data._modal.content = '';
        }
        app.data._modal.close = true;
    }
    app.update();
    $('#app-modal').modal('show')
    $('#app-modal').on('shown.bs.modal', function () {
        if (typeof callback !== 'undefined') {
            callback();
        }
    })
}
$(document).on('hidden.bs.modal', '#app-modal', function (e) {
    app.data._modal.content = '';
    app.data._modal.title = '';
    app.update();
})

app.click = function(selector, callback) {
    $(document).on("click", selector, callback);
    $(document).on("keypress", selector, function(event) {
        if (event.keyCode === 13) {
            callback(event);
        }
    });
}

// gform: WAVE expects <label for="id"> to match the control id. aria-labelledby alone often still reports orphaned/missing labels.
// Switch rows also set el.labels from the inner <label.switch>, so we must not skip those — fix the outer .control-label for="" instead.
app.gform = app.gform || {};

app.gform.ensureFieldAccessibleNames = function(root) {
    var scope = root;
    if (typeof root === 'string') {
        scope = document.querySelector(root);
    }
    if (!scope) {
        scope = document;
    }

    var fields = scope.querySelectorAll('.gform input, .gform select, .gform textarea');
    _.each(fields, function(el) {
        var type = (el.type || '').toLowerCase();
        if (type === 'hidden' || type === 'button' || type === 'submit' || type === 'reset' || type === 'image') {
            return;
        }

        var group = el.closest('.form-group') || el.closest('.row.clearfix[data-type]') || el.closest('[data-type]');
        if (!group) {
            return;
        }

        var lbl = group.querySelector('label.control-label');
        if (!lbl) {
            return;
        }

        var text = (lbl.textContent || '').replace(/\s+/g, ' ').trim();
        if (!text) {
            return;
        }

        if (!el.id) {
            var base = lbl.getAttribute('for') || el.getAttribute('name') || 'field';
            base = String(base).replace(/[^a-zA-Z0-9_-]/g, '-');
            var newId = 'gform-ctrl-' + base;
            var n = 0;
            while (document.getElementById(newId)) {
                n += 1;
                newId = 'gform-ctrl-' + base + '-' + n;
            }
            el.id = newId;
        }

        if (lbl.getAttribute('for') === el.id) {
            el.removeAttribute('aria-labelledby');
            el.removeAttribute('aria-label');
            return;
        }

        lbl.setAttribute('for', el.id);
        el.removeAttribute('aria-labelledby');
        el.removeAttribute('aria-label');
    });

    _.each(scope.querySelectorAll('.gform label.switch'), function(switchLabel) {
        if (switchLabel.getAttribute('data-gform-switch-a11y') === '1') {
            return;
        }
        var group = switchLabel.closest('.form-group') || switchLabel.closest('.row.clearfix[data-type]') || switchLabel.closest('[data-type]');
        if (!group) {
            return;
        }
        var ctrl = group.querySelector('label.control-label');
        if (!ctrl) {
            return;
        }
        var switchText = (ctrl.textContent || '').replace(/\s+/g, ' ').trim();
        if (!switchText) {
            return;
        }
        switchLabel.setAttribute('aria-label', switchText);
        switchLabel.setAttribute('data-gform-switch-a11y', '1');
    });
};

$(function () {
    $('body').tooltip({
        selector: '[data-toggle=tooltip]'
    });
    app.gform.ensureFieldAccessibleNames(document);
})

// gform-style switches: native checkboxes toggle with Space; also toggle on Enter app-wide.
// Capture phase so Enter is handled before form submit; do not use :visible — switch inputs are often visually hidden but still focused.
document.addEventListener('keydown', function(event) {
    if (event.key !== 'Enter') {
        return;
    }
    var target = event.target;
    if (!target || target.tagName !== 'INPUT' || target.type !== 'checkbox' || target.disabled) {
        return;
    }
    if (!target.closest('label.switch')) {
        return;
    }
    event.preventDefault();
    // target.checked = !target.checked;
    // if (typeof $ !== 'undefined') {
    //     $(target).trigger('change');
    // } else {
    //     target.dispatchEvent(new Event('change', { bubbles: true }));
    // }
}, true);

$(document).on('shown.bs.modal', '.modal', function() {
    if (this.querySelector && this.querySelector('.gform')) {
        app.gform.ensureFieldAccessibleNames(this);
    }
});

app.copy = function(selector) {
    var range = document.createRange();
    range.selectNode(document.querySelector(selector));
    window.getSelection().removeAllRanges(); 
    window.getSelection().addRange(range); 
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
    app.alert("Copied to Clipboard")
}

// GrapheneDataGrid helpers: labels, table semantics, and styles (see .gdatagrid-enhanced in CSS).
app.gdatagrid = app.gdatagrid || {};

// Plain text for a column header (used for aria-labels and filter names).
app.gdatagrid._getHeaderText = function(th) {
    if (!th) {
        return '';
    }

    var text_node = th.querySelector('h1, h2, h3, h4, h5, h6, span, div') || th;
    var text = (text_node.textContent || '').replace(/\s+/g, ' ').trim();
    return text;
};

// Give empty or icon-only <th> a name screen readers can announce.
app.gdatagrid._ensureHeaderHasName = function(th, fallback_text) {
    if (!th) {
        return;
    }

    var header_text = app.gdatagrid._getHeaderText(th);
    if (!header_text && fallback_text) {
        var sr_text = th.querySelector('.sr-only[data-gdatagrid-header]');
        if (!sr_text) {
            sr_text = document.createElement('span');
            sr_text.className = 'sr-only';
            sr_text.setAttribute('data-gdatagrid-header', 'true');
            th.appendChild(sr_text);
        }
        sr_text.textContent = fallback_text;
        header_text = fallback_text;
    }

    if (header_text) {
        th.setAttribute('aria-label', header_text);
    }
};

app.gdatagrid._findScrollableTableContainer = function(root, table) {
    if (!root || !table) {
        return null;
    }

    var preferred = root.querySelector('.table-responsive, .dataTables_scrollBody, .dataTables_wrapper');
    if (preferred && preferred.contains(table)) {
        return preferred;
    }

    var node = table.parentElement;
    while (node && node !== root) {
        var has_horizontal_scroll = node.scrollWidth > node.clientWidth;
        var has_vertical_scroll = node.scrollHeight > node.clientHeight;
        if (has_horizontal_scroll || has_vertical_scroll) {
            return node;
        }
        node = node.parentElement;
    }

    return null;
};

app.gdatagrid._enableKeyboardScroll = function(scroll_region) {
    if (!scroll_region) {
        return;
    }

    if (!scroll_region.getAttribute('tabindex')) {
        scroll_region.setAttribute('tabindex', '0');
    }
    scroll_region.setAttribute('data-gdatagrid-scrollable', 'true');

    if (scroll_region.getAttribute('data-gdatagrid-scroll-keys-bound') === 'true') {
        return;
    }

    scroll_region.addEventListener('keydown', function(event) {
        var horizontal_step = 40;
        var vertical_step = 40;
        var handled = true;

        switch (event.key) {
            case 'ArrowLeft':
                scroll_region.scrollLeft -= horizontal_step;
                break;
            case 'ArrowRight':
                scroll_region.scrollLeft += horizontal_step;
                break;
            case 'Home':
                scroll_region.scrollLeft = 0;
                break;
            case 'End':
                scroll_region.scrollLeft = scroll_region.scrollWidth;
                break;
            case 'ArrowUp':
                scroll_region.scrollTop -= vertical_step;
                break;
            case 'ArrowDown':
                scroll_region.scrollTop += vertical_step;
                break;
            case 'PageUp':
                scroll_region.scrollTop -= scroll_region.clientHeight;
                break;
            case 'PageDown':
                scroll_region.scrollTop += scroll_region.clientHeight;
                break;
            default:
                handled = false;
        }

        if (handled) {
            event.preventDefault();
        }
    });

    scroll_region.setAttribute('data-gdatagrid-scroll-keys-bound', 'true');
};

// Run once on a grid container. Safe to call again after the table re-renders.
app.gdatagrid.enhanceDataGrid = function(container, options) {
    var root = container;
    if (typeof container === 'string') {
        root = document.querySelector(container);
    }
    if (!root) {
        return;
    }
    root.classList.add('gdatagrid-enhanced'); // hooks contrast rules in CSS

    var config = options || {};
    var table = root.querySelector('table.dataTable');
    if (!table) {
        return;
    }

    // Headings inside <th> break outline order; use spans instead.
    var heading_elements = table.querySelectorAll('thead th h1, thead th h2, thead th h3, thead th h4, thead th h5, thead th h6');
    _.each(heading_elements, function(heading) {
        var replacement = document.createElement('span');
        replacement.className = heading.className;
        replacement.setAttribute('style', heading.getAttribute('style') || '');
        replacement.innerHTML = heading.innerHTML;
        heading.parentNode.replaceChild(replacement, heading);
    });

    if (!table.getAttribute('aria-label')) {
        table.setAttribute('aria-label', config.tableLabel || 'Data grid results');
    }

    var caption_text = config.tableCaption || config.tableLabel || 'Data grid results';
    var caption = table.querySelector('caption');
    if (!caption) {
        caption = document.createElement('caption');
        caption.className = 'sr-only';
        table.insertBefore(caption, table.firstChild);
    }
    caption.textContent = caption_text;

    var scroll_region = app.gdatagrid._findScrollableTableContainer(root, table);
    if (scroll_region) {
        var scroll_region_label = config.scrollRegionLabel || (caption_text + ' scroll region');
        scroll_region.setAttribute('role', 'region');
        scroll_region.setAttribute('aria-label', scroll_region_label);
        app.gdatagrid._enableKeyboardScroll(scroll_region);
    }

    // Map column id -> header label; used for filter row inputs below.
    var header_map = {};
    var select_column_label = config.selectColumnLabel || 'Select row';
    // Checkbox column + sort row headers (names for empty/icon cells).
    var sort_row_headers = table.querySelectorAll('thead tr.table-sort th');
    _.each(sort_row_headers, function(th) {
        if (th.classList.contains('select-column')) {
            app.gdatagrid._ensureHeaderHasName(th, select_column_label);
            var select_icon = th.querySelector('[name="select_all"]');
            if (select_icon) {
                select_icon.setAttribute('aria-label', select_column_label);
                select_icon.setAttribute('role', 'button');
                select_icon.setAttribute('tabindex', '0');
            }
        } else {
            app.gdatagrid._ensureHeaderHasName(th, null);
        }
    });

    // Fill header_map from data-sort columns.
    var header_cells = table.querySelectorAll('thead tr.table-sort th[data-sort]');
    _.each(header_cells, function(th) {
        var field = th.getAttribute('data-sort');
        var label = app.gdatagrid._getHeaderText(th);
        if (field && label) {
            header_map[field] = label;
        }
    });

    // Filter inputs: "Column name filter"
    var filter_cells = table.querySelectorAll('thead tr.filter td[data-inline]');
    _.each(filter_cells, function(td) {
        var field = td.getAttribute('data-inline');
        var label = header_map[field];
        if (!label) {
            return;
        }
        var controls = td.querySelectorAll('input, select, textarea');
        _.each(controls, function(control) {
            control.setAttribute('aria-label', label + ' filter');
        });
    });

    // Toolbar links: treat as buttons for keyboard and SR.
    var action_buttons = root.querySelectorAll('a.grid-action, .btn-group .grid-action');
    _.each(action_buttons, function(button) {
        var label = (button.textContent || '').replace(/\s+/g, ' ').trim();
        if (label && !button.getAttribute('aria-label')) {
            button.setAttribute('aria-label', label);
        }
        button.setAttribute('role', 'button');
        button.setAttribute('tabindex', button.classList.contains('disabled') ? '-1' : '0');
        button.setAttribute('aria-disabled', button.classList.contains('disabled') ? 'true' : 'false');
    });

    // "Showing X–Y…" / selected count: not real headings; use status region.
    var range_headings = root.querySelectorAll('h5.range');
    _.each(range_headings, function(heading) {
        var status = document.createElement('div');
        status.className = heading.className;
        status.setAttribute('style', heading.getAttribute('style') || '');
        status.setAttribute('role', 'status');
        status.setAttribute('aria-live', heading.classList.contains('checked_count') ? 'polite' : 'off');
        status.textContent = heading.textContent;
        heading.parentNode.replaceChild(status, heading);
    });
};

// Enhance now and whenever the library redraws the grid (sort, filter, etc.).
app.gdatagrid.bindDataGrid = function(container, options) {
    var root = container;
    if (typeof container === 'string') {
        root = document.querySelector(container);
    }
    if (!root) {
        return null;
    }

    app.gdatagrid.enhanceDataGrid(root, options);

    // Re-run enhance after DOM changes (debounced so we do not run too often).
    var pending = null;
    var observer = new MutationObserver(function() {
        if (pending) {
            clearTimeout(pending);
        }
        pending = setTimeout(function() {
            app.gdatagrid.enhanceDataGrid(root, options);
        }, 50);
    });

    observer.observe(root, {childList: true, subtree: true});
    return observer;
};


