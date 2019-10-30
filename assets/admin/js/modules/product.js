'use strict';

window.addEventListener('load', () => {
    let container;
    let attributeValues = null;

    container = document.querySelector('.form-group[id$="_attributeValues"]');

    if (container) {

        initAttributeValues();

        $(document).on('sonata.add_element', function() {
            $('.js-product-attribute').trigger('change');
        });

        $(container).on('change', (event) => {
            if (event.target.tagName === 'SELECT'
                && event.target.classList.contains('js-product-attribute'
                )) {
                filterAttributeValues(event.target);
            }
        });
    }

    function initAttributeValues() {
        let result = [];
        let valuesSelect = container.querySelector('select.js-product-attribute-value');

        if (!valuesSelect) {
            $(document).on('sonata.add_element', function() {
                if (attributeValues === null) {
                    initAttributeValues();
                }
            });

            return;
        }

        valuesSelect.options.forEach((option) => {
            result.push({
                value: option.value,
                label: option.innerHTML,
                attributeId: option.dataset.attributeId
            });
        });

        attributeValues = result;
    }

    function filterAttributeValues(attributeSelect) {
        let attributeId = attributeSelect.selectedOptions.item(0).value;
        let row = attributeSelect.closest('tr');
        let valueSelect = row.querySelector('select.js-product-attribute-value');

        valueSelect.innerHTML = '';

        attributeValues.forEach((item) => {
            if (item.attributeId === attributeId) {
                let option = document.createElement('option');
                option.value = item.value;
                option.innerHTML = item.label;
                valueSelect.add(option);
            }
        });

        $(valueSelect).trigger('change');
    }

});