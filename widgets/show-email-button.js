jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(ElementorWidgetShowEmailButton, {
            $element,
        } );
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/show-email-button.default', addHandler);
 } );

class ElementorWidgetShowEmailButton extends elementorModules.frontend.handlers.Base {

    getDefaultSettings() {
        return {
            selectors: {
                button: '.elementor-widget-show-email-button-button',
                body: '.elementor-widget-show-email-button-body',
            },
        };
    }
 
    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $button: this.$element.find(selectors.button),
            $body: this.$element.find(selectors.body),
        };
    }
 
    bindEvents() {
        this.elements.$body.on('click', this.onClick.bind(this));
    }
 
    onClick(event) {
        let fEmail = this.elements.$button.attr('em_name') + '@' + this.elements.$button.attr('em_domain') + '.' + this.elements.$button.attr('em_zone');
        let fullEmailText = '<div class="elementor-widget-show-email-button-mail"><a href="mailto:' + fEmail + '">' + fEmail + '</a></div>';
        this.elements.$button.fadeOut().promise().done( () => {
            this.elements.$body.html(fullEmailText);
        } );
    }
 }
