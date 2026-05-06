/**
 * Project-specific accessibility enhancements.
 * Keep this file separate from generated framework/vendor assets.
 */
(function(window, document, $, _) {
    'use strict';

    if (window.__appA11yLoaded) {
        return;
    }
    window.__appA11yLoaded = true;

    window.app = window.app || {};

    // gform: ensure visible control labels are programmatically associated.
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
                var new_id = 'gform-ctrl-' + base;
                var n = 0;
                while (document.getElementById(new_id)) {
                    n += 1;
                    new_id = 'gform-ctrl-' + base + '-' + n;
                }
                el.id = new_id;
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

        _.each(scope.querySelectorAll('.gform label.switch'), function(switch_label) {
            if (switch_label.getAttribute('data-gform-switch-a11y') === '1') {
                return;
            }
            var group = switch_label.closest('.form-group') || switch_label.closest('.row.clearfix[data-type]') || switch_label.closest('[data-type]');
            if (!group) {
                return;
            }
            var ctrl = group.querySelector('label.control-label');
            if (!ctrl) {
                return;
            }
            var switch_text = (ctrl.textContent || '').replace(/\s+/g, ' ').trim();
            if (!switch_text) {
                return;
            }
            switch_label.setAttribute('aria-label', switch_text);
            switch_label.setAttribute('data-gform-switch-a11y', '1');
        });
    };

    // gform switches: support both Space and Enter on focused hidden checkboxes.
    document.addEventListener('keydown', function(event) {
        if (event.key !== 'Enter' && event.key !== ' ') {
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
        target.checked = !target.checked;
        if (typeof $ !== 'undefined') {
            $(target).trigger('change');
        } else {
            target.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }, true);

    $(document).on('shown.bs.modal', '.modal', function() {
        if (this.querySelector && this.querySelector('.gform')) {
            app.gform.ensureFieldAccessibleNames(this);
        }
    });

    $(function() {
        app.gform.ensureFieldAccessibleNames(document);
    });

    // GrapheneDataGrid helpers: labels, table semantics, and keyboard scroll.
    app.gdatagrid = app.gdatagrid || {};

    app.gdatagrid._getHeaderText = function(th) {
        if (!th) {
            return '';
        }
        var text_node = th.querySelector('h1, h2, h3, h4, h5, h6, span, div') || th;
        return (text_node.textContent || '').replace(/\s+/g, ' ').trim();
    };

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

        var is_scrollable = function(node) {
            if (!node) {
                return false;
            }
            return node.scrollWidth > node.clientWidth || node.scrollHeight > node.clientHeight;
        };

        var preferred = root.querySelector('.table-responsive, .dataTables_scrollBody, .dataTables_wrapper');
        if (preferred && preferred.contains(table) && is_scrollable(preferred)) {
            return preferred;
        }

        var node = table.parentElement;
        while (node && node !== root) {
            if (is_scrollable(node)) {
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

    app.gdatagrid._isCheckedIcon = function(icon) {
        if (!icon) {
            return false;
        }
        return icon.classList.contains('fa-check-square-o') || icon.classList.contains('fa-check-square');
    };

    app.gdatagrid._wireKeyboardClick = function(el) {
        if (!el || el.getAttribute('data-a11y-keybound') === 'true') {
            return;
        }
        el.addEventListener('keydown', function(event) {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }
            event.preventDefault();
            el.click();
        });
        el.setAttribute('data-a11y-keybound', 'true');
    };

    app.gdatagrid._getRowAccessibleName = function(row) {
        if (!row) {
            return '';
        }

        var from_attr = row.getAttribute('data-title') || row.getAttribute('aria-label');
        if (from_attr && from_attr.trim()) {
            return from_attr.replace(/\s+/g, ' ').trim();
        }

        var named_target = row.querySelector('a[href], strong, b, h1, h2, h3, h4, h5, h6');
        if (named_target) {
            var named_text = (named_target.textContent || '').replace(/\s+/g, ' ').trim();
            if (named_text) {
                return named_text;
            }
        }

        var data_cells = row.querySelectorAll('td');
        for (var i = 0; i < data_cells.length; i += 1) {
            var cell = data_cells[i];
            if (cell.classList.contains('select-column')) {
                continue;
            }
            var cell_text = (cell.textContent || '').replace(/\s+/g, ' ').trim();
            if (cell_text) {
                return cell_text;
            }
        }

        var row_id = row.getAttribute('data-id') || row.id;
        return row_id ? ('Row ' + row_id) : '';
    };

    app.gdatagrid._getRowTextByField = function(table, row, field_name) {
        if (!table || !row || !field_name) {
            return '';
        }
        var header = table.querySelector('thead tr.table-sort th[data-sort="' + field_name + '"]');
        if (!header || typeof header.cellIndex !== 'number') {
            return '';
        }
        var cell = row.cells && row.cells[header.cellIndex] ? row.cells[header.cellIndex] : null;
        if (!cell) {
            return '';
        }
        return (cell.textContent || '').replace(/\s+/g, ' ').trim();
    };

    app.gdatagrid._syncSelectionA11y = function(root, table) {
        if (!root || !table) {
            return;
        }

        var select_all_icon = table.querySelector('thead [name="select_all"], thead th.select-column i.fa, thead th.select-column span.fa');
        var row_icons = table.querySelectorAll('tbody [name="selected"], tbody td.select-column i, tbody td.select-column span.fa, tbody tr td:first-child i.fa, tbody tr td:first-child span.fa');
        var selected_count = 0;
        _.each(table.querySelectorAll('tbody tr'), function(row) {
            row.setAttribute('aria-selected', 'false');
        });
        _.each(row_icons, function(icon) {
            var row = icon.closest('tr');
            var checked = app.gdatagrid._isCheckedIcon(icon);
            if (checked) {
                selected_count += 1;
            }
            var row_name = '';
            if (row) {
                row_name = app.gdatagrid._getRowTextByField(table, row, 'title') || app.gdatagrid._getRowAccessibleName(row);
                row.setAttribute('aria-selected', checked ? 'true' : 'false');
            }

            icon.setAttribute('role', 'checkbox');
            icon.setAttribute('tabindex', '0');
            icon.setAttribute('aria-checked', checked ? 'true' : 'false');
            icon.setAttribute('aria-label', row_name ? ('Select row: ' + row_name) : 'Select row');
            app.gdatagrid._wireKeyboardClick(icon);
        });

        if (select_all_icon) {
            select_all_icon.setAttribute('role', 'checkbox');
            select_all_icon.setAttribute('tabindex', '0');
            if (selected_count === 0) {
                select_all_icon.setAttribute('aria-checked', 'false');
            } else if (selected_count === row_icons.length) {
                select_all_icon.setAttribute('aria-checked', 'true');
            } else {
                select_all_icon.setAttribute('aria-checked', 'mixed');
            }
            app.gdatagrid._wireKeyboardClick(select_all_icon);
        }

        var status = root.querySelector('#gdatagrid-selection-status');
        if (!status) {
            status = document.createElement('div');
            status.id = 'gdatagrid-selection-status';
            status.className = 'sr-only';
            status.setAttribute('aria-live', 'polite');
            status.setAttribute('aria-atomic', 'true');
            root.appendChild(status);
        }
        status.textContent = selected_count === 0
            ? 'No rows selected.'
            : (selected_count + ' row' + (selected_count === 1 ? '' : 's') + ' selected. Actions available.');

        if (root.getAttribute('data-gdatagrid-selection-events-bound') !== 'true') {
            var refresh = function() {
                window.setTimeout(function() {
                    app.gdatagrid._syncSelectionA11y(root, table);
                }, 0);
            };
            root.addEventListener('click', refresh, true);
            root.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    refresh();
                }
            }, true);
            root.setAttribute('data-gdatagrid-selection-events-bound', 'true');
        }
    };

    app.gdatagrid.enhanceDataGrid = function(container, options) {
        var root = container;
        if (typeof container === 'string') {
            root = document.querySelector(container);
        }
        if (!root) {
            return;
        }
        root.classList.add('gdatagrid-enhanced');

        var config = options || {};
        var table = root.querySelector('table.dataTable');
        if (!table) {
            return;
        }
        table.setAttribute('role', 'grid');

        _.each(table.querySelectorAll('thead tr, tbody tr'), function(row) {
            row.setAttribute('role', 'row');
        });
        _.each(table.querySelectorAll('thead th, tbody td'), function(cell) {
            if (cell.tagName === 'TH') {
                cell.setAttribute('role', 'columnheader');
            } else {
                cell.setAttribute('role', 'gridcell');
            }
        });

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

        var header_map = {};
        var select_column_label = config.selectColumnLabel || 'Select row';
        var sort_row_headers = table.querySelectorAll('thead tr.table-sort th');
        _.each(sort_row_headers, function(th) {
            if (th.classList.contains('select-column')) {
                app.gdatagrid._ensureHeaderHasName(th, select_column_label);
                var select_icon = th.querySelector('[name="select_all"]');
                if (select_icon) {
                    select_icon.setAttribute('aria-label', select_column_label);
                }
            } else {
                app.gdatagrid._ensureHeaderHasName(th, null);
            }
        });

        var header_cells = table.querySelectorAll('thead tr.table-sort th[data-sort]');
        _.each(header_cells, function(th) {
            var field = th.getAttribute('data-sort');
            var label = app.gdatagrid._getHeaderText(th);
            if (field && label) {
                header_map[field] = label;
                if (!th.id) {
                    th.id = 'gdatagrid-col-' + String(field).replace(/[^a-zA-Z0-9_-]/g, '-');
                }
                th.setAttribute('scope', 'col');
            }
            th.setAttribute('role', 'button');
            th.setAttribute('tabindex', '0');
            if (!th.getAttribute('aria-label') && label) {
                th.setAttribute('aria-label', 'Sort by ' + label);
            }
            if (th.classList.contains('sorting_asc')) {
                th.setAttribute('aria-sort', 'ascending');
            } else if (th.classList.contains('sorting_desc')) {
                th.setAttribute('aria-sort', 'descending');
            } else {
                th.setAttribute('aria-sort', 'none');
            }
            app.gdatagrid._wireKeyboardClick(th);
        });

        var filter_cells = table.querySelectorAll('thead tr.filter td[data-inline]');
        _.each(filter_cells, function(td) {
            var field = td.getAttribute('data-inline');
            var label = header_map[field];
            if (!label) {
                return;
            }
            var th = table.querySelector('thead tr.table-sort th[data-sort="' + field + '"]');
            if (th && th.id) {
                td.setAttribute('headers', th.id);
            }
            var controls = td.querySelectorAll('input, select, textarea');
            _.each(controls, function(control) {
                if (th && th.id) {
                    control.setAttribute('aria-labelledby', th.id);
                    control.removeAttribute('aria-label');
                } else {
                    control.setAttribute('aria-label', label + ' filter');
                }
            });
        });

        var action_buttons = root.querySelectorAll('a.grid-action, .btn-group .grid-action');
        _.each(action_buttons, function(button) {
            var label = (button.textContent || '').replace(/\s+/g, ' ').trim();
            if (label && !button.getAttribute('aria-label')) {
                button.setAttribute('aria-label', label);
            }
            button.setAttribute('role', 'button');
            button.setAttribute('tabindex', button.classList.contains('disabled') ? '-1' : '0');
            button.setAttribute('aria-disabled', button.classList.contains('disabled') ? 'true' : 'false');
            app.gdatagrid._wireKeyboardClick(button);
        });

        var clear_filters_controls = root.querySelectorAll('thead tr.filter .btn, thead tr.filter [data-event="clear"], thead tr.filter [name="clear"]');
        _.each(clear_filters_controls, function(control) {
            if (!control.getAttribute('aria-label')) {
                control.setAttribute('aria-label', 'Clear all filters');
            }
            if (control.tagName !== 'BUTTON') {
                control.setAttribute('role', 'button');
                control.setAttribute('tabindex', '0');
                app.gdatagrid._wireKeyboardClick(control);
            }
        });

        var filter_select_cell = table.querySelector('thead tr.filter td.select-column');
        var select_header = table.querySelector('thead tr.table-sort th.select-column');
        if (filter_select_cell && select_header) {
            if (!select_header.id) {
                select_header.id = 'gdatagrid-col-select';
            }
            filter_select_cell.setAttribute('headers', select_header.id);
        }

        var groups = root.querySelectorAll('[role="group"][aria-label="..."]');
        _.each(groups, function(group, index) {
            group.setAttribute('aria-label', index === 0 ? 'Primary actions' : 'Secondary actions');
        });
        _.each(root.querySelectorAll('[role="group"][aria-label]'), function(group) {
            var has_content = (group.textContent || '').replace(/\s+/g, '').length > 0;
            var has_controls = !!group.querySelector('a, button, input, select, textarea, [tabindex], [role="button"]');
            if (!has_content && !has_controls) {
                group.removeAttribute('role');
                group.removeAttribute('aria-label');
            }
        });

        var range_headings = root.querySelectorAll('h5.range');
        _.each(range_headings, function(heading) {
            var status = document.createElement('div');
            status.className = heading.className;
            status.setAttribute('style', heading.getAttribute('style') || '');
            status.setAttribute('role', 'status');
            status.setAttribute('aria-live', 'polite');
            status.textContent = heading.textContent;
            heading.parentNode.replaceChild(status, heading);
        });

        app.gdatagrid._syncSelectionA11y(root, table);
    };

    app.gdatagrid.bindDataGrid = function(container, options) {
        var root = container;
        if (typeof container === 'string') {
            root = document.querySelector(container);
        }
        if (!root) {
            return null;
        }

        app.gdatagrid.enhanceDataGrid(root, options);

        var pending = null;
        var observer = new MutationObserver(function() {
            if (pending) {
                clearTimeout(pending);
            }
            pending = setTimeout(function() {
                app.gdatagrid.enhanceDataGrid(root, options);
            }, 50);
        });

        observer.observe(root, { childList: true, subtree: true });
        return observer;
    };
})(window, document, jQuery, _);
