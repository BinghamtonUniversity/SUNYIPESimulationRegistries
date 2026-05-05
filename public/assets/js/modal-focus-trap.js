/**
 * Bootstrap modal focus trap for accessibility (Tab cycle, focus return).
 * Optional: window.APP_MODAL_FOCUS_PREFERRED — map modal element id → CSS selector
 * for the preferred first focused field inside that modal.
 * Programmatic opens: window.scheduleModalTrapActivation(triggerElement) after .modal().
 */
(function (window, $, _) {
    'use strict';

    var modal_focus_trap_state = {
        active_modal: null,
        trigger_element: null
    };

    function getPreferredSelectors() {
        return window.APP_MODAL_FOCUS_PREFERRED || {};
    }

    function getModalFocusableElements(modal) {
        if (!modal) {
            return [];
        }
        var selector = 'a[href], area[href], input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex]:not([tabindex="-1"]), [contenteditable="true"]';
        return _.filter(modal.querySelectorAll(selector), function (element) {
            return element.offsetParent !== null;
        });
    }

    function getPreferredModalFocusElement(modal) {
        if (!modal) {
            return null;
        }
        var modal_id = modal.getAttribute('id');
        var preferred_selector = modal_id ? getPreferredSelectors()[modal_id] : null;
        if (preferred_selector) {
            var preferred_element = modal.querySelector(preferred_selector);
            if (preferred_element) {
                return preferred_element;
            }
        }
        return modal.querySelector('[autofocus]');
    }

    function focusWithinModal(modal) {
        if (!modal || !$(modal).is(':visible')) {
            return;
        }
        var preferred_element = getPreferredModalFocusElement(modal);
        if (preferred_element) {
            preferred_element.focus();
            return;
        }
        var focusable = getModalFocusableElements(modal);
        if (focusable.length) {
            focusable[0].focus();
            return;
        }
        modal.setAttribute('tabindex', '-1');
        modal.focus();
    }

    function activateModalFocusTrap(modal, trigger_element) {
        modal_focus_trap_state.active_modal = modal;
        modal_focus_trap_state.trigger_element = trigger_element || document.activeElement;
    }

    function getTopVisibleModal() {
        var visible_modals = $('.modal:visible').toArray();
        return visible_modals.length ? visible_modals[visible_modals.length - 1] : null;
    }

    function ensureActiveModalFocusTrap() {
        var active_modal = modal_focus_trap_state.active_modal;
        if (active_modal && $(active_modal).is(':visible')) {
            return active_modal;
        }
        var top_modal = getTopVisibleModal();
        if (top_modal) {
            activateModalFocusTrap(top_modal, modal_focus_trap_state.trigger_element || document.activeElement);
        } else {
            modal_focus_trap_state.active_modal = null;
        }
        return modal_focus_trap_state.active_modal;
    }

    function scheduleModalTrapActivation(trigger_element, attempt) {
        var max_attempts = 20;
        var current_attempt = attempt || 0;
        var top_modal = getTopVisibleModal();
        if (top_modal) {
            activateModalFocusTrap(top_modal, trigger_element);
            focusWithinModal(top_modal);
            return;
        }
        if (current_attempt < max_attempts) {
            setTimeout(function () {
                scheduleModalTrapActivation(trigger_element, current_attempt + 1);
            }, 100);
        }
    }

    function releaseModalFocusTrap(trigger_override) {
        var trigger_element = trigger_override || modal_focus_trap_state.trigger_element;
        modal_focus_trap_state.active_modal = null;
        modal_focus_trap_state.trigger_element = null;
        if (trigger_element && typeof trigger_element.focus === 'function' && document.contains(trigger_element)) {
            trigger_element.focus();
        }
    }

    $(document).on('show.bs.modal', '.modal', function () {
        this._focusTriggerElement = document.activeElement;
    });

    $(document).on('shown.bs.modal', '.modal', function () {
        activateModalFocusTrap(this, this._focusTriggerElement);
        focusWithinModal(this);
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
        var top_modal = getTopVisibleModal();
        if (top_modal) {
            activateModalFocusTrap(top_modal, modal_focus_trap_state.trigger_element);
            focusWithinModal(top_modal);
        } else if (modal_focus_trap_state.active_modal === this) {
            releaseModalFocusTrap(this._focusTriggerElement);
        } else {
            releaseModalFocusTrap(this._focusTriggerElement);
        }
        this._focusTriggerElement = null;
    });

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Tab') {
            return;
        }
        var modal = ensureActiveModalFocusTrap();
        if (!modal) {
            return;
        }
        var focusable = getModalFocusableElements(modal);
        if (!focusable.length) {
            event.preventDefault();
            modal.setAttribute('tabindex', '-1');
            modal.focus();
            return;
        }
        var first = focusable[0];
        var last = focusable[focusable.length - 1];
        var active_element = document.activeElement;
        if (event.shiftKey) {
            if (active_element === first || !modal.contains(active_element)) {
                event.preventDefault();
                last.focus();
            }
        } else if (active_element === last || !modal.contains(active_element)) {
            event.preventDefault();
            first.focus();
        }
    });

    document.addEventListener('focusin', function (event) {
        var modal = ensureActiveModalFocusTrap();
        if (!modal) {
            return;
        }
        if (!modal.contains(event.target)) {
            focusWithinModal(modal);
        }
    });

    window.scheduleModalTrapActivation = scheduleModalTrapActivation;
})(window, jQuery, _);
