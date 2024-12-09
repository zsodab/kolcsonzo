document.addEventListener("DOMContentLoaded", function() {
    //majd megpróbálhatnám szebbre, szörnyű a redundancia, de előbb működjön teljesen, egyelőre elmegy
    fetch(BASE_URL + 'json/autoink.json')
    .then(response => response.json())
    .then(autoink => {
        const locationSelect = document.getElementById("location");
        const brandSelect = document.getElementById("brand");
        const modelSelect = document.getElementById("model");
        const yearSelect = document.getElementById("year");
        const fuelTypeSelect = document.getElementById("fuelType");


        const defaultTexts = {
            location: "Válasszon várost!",
            brand: "Válasszon márkát!",
            model: "Válasszon modellt!",
            year: "Válasszon évjáratot!",
            fuelType: "Válasszon üzemanyag típust!"
        };


        modelSelect.disabled = true;

        function clearSelect(selectElement, defaultText) {
            selectElement.innerHTML = `<option value=''>${defaultText}</option>`;
        }

        function updateAvailableOptions(event) {
            const selectedLocation = locationSelect.value;
            if (!selectedLocation) {
                clearSelect(brandSelect, defaultTexts.brand);
                clearSelect(modelSelect, defaultTexts.model);
                clearSelect(yearSelect, defaultTexts.year);
                clearSelect(fuelTypeSelect, defaultTexts.fuelType);
                modelSelect.disabled = true;
                return;
            }
        
            const triggerElement = event.target;
            const selections = {
                brand: brandSelect.value,
                model: modelSelect.value,
                year: yearSelect.value,
                fuelType: fuelTypeSelect.value
            };
        

            if (triggerElement && !triggerElement.value) {
                if (triggerElement === brandSelect) {
                    selections.model = '';
                    modelSelect.value = '';
                }
            }
        
            let filteredData = autoink[selectedLocation];
            const options = {
                brand: new Set(),
                model: new Set(),
                year: new Set(),
                fuelType: new Set()
            };
        
            Object.entries(filteredData).forEach(([brand, brandData]) => {
                Object.entries(brandData).forEach(([model, modelData]) => {
                    Object.entries(modelData).forEach(([year, fuelTypes]) => {
                        const shouldInclude = 
                            (!selections.brand || brand === selections.brand) &&
                            (!selections.model || model === selections.model) &&
                            (!selections.year || year === selections.year) &&
                            (!selections.fuelType || fuelTypes.includes(selections.fuelType));
        
                        if (shouldInclude) {
                            options.brand.add(brand);
                            if (selections.brand === brand) {
                                options.model.add(model);
                            }
                            options.year.add(year);
                            fuelTypes.forEach(ft => options.fuelType.add(ft));
                        }
                    });
                });
            });
        

            if (triggerElement !== brandSelect) updateSelect(brandSelect, options.brand, defaultTexts.brand);
            if (triggerElement !== modelSelect) updateSelect(modelSelect, options.model, defaultTexts.model);
            if (triggerElement !== yearSelect) updateSelect(yearSelect, options.year, defaultTexts.year);
            if (triggerElement !== fuelTypeSelect) updateSelect(fuelTypeSelect, options.fuelType, defaultTexts.fuelType);
        
            modelSelect.disabled = !selections.brand;
            if (!selections.brand) {
                clearSelect(modelSelect, defaultTexts.model);
            }
        }

        function updateSelect(selectElement, options, defaultText) {
            const currentValue = selectElement.value;
            clearSelect(selectElement, defaultText);
            

            const sortedOptions = Array.from(options).sort();
            
            sortedOptions.forEach(option => {
                const optionElement = document.createElement("option");
                optionElement.value = option;
                optionElement.textContent = option;
                selectElement.appendChild(optionElement);
            });


            if (options.has(currentValue)) {
                selectElement.value = currentValue;
            }
        }


        locationSelect.addEventListener("change", updateAvailableOptions);
        brandSelect.addEventListener("change", updateAvailableOptions);
        modelSelect.addEventListener("change", updateAvailableOptions);
        yearSelect.addEventListener("change", updateAvailableOptions);
        fuelTypeSelect.addEventListener("change", updateAvailableOptions);
    })
    .catch(error => console.error('Hiba az autoink.json betöltésekor:', error));

    
    const resetButton = document.getElementById("reset-button");
    const locationSelect = document.getElementById("location");
    const brandSelect = document.getElementById("brand");
    const modelSelect = document.getElementById("model");
    const yearSelect = document.getElementById("year");
    const fuelTypeSelect = document.getElementById("fuelType");

    if (!resetButton) {
        console.error("Reset gomb nem találva!");
        return;
    }

    resetButton.addEventListener("click", function () {
        //console.log("Reset gomb megnyomva");

        
        locationSelect.value = '';
        brandSelect.innerHTML = "<option value=''>Válasszon márkát!</option>";
        modelSelect.innerHTML = "<option value=''>Válasszon modellt!</option>";
        yearSelect.innerHTML = "<option value=''>Válasszon évjáratot!</option>";
        fuelTypeSelect.innerHTML = "<option value=''>Válasszon üzemanyag típust!</option>";

        
        //document.getElementById("car-results").innerHTML = '';
    });

    
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: BASE_URL + 'search/searchCar.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                $('#car-results').html(data);
                attachCarBoxListeners();
            },
            error: function() {
                alert('Hiba történt a keresés során.');
            }
        });
    });


    function attachCarBoxListeners() {
        $('.car-box').append('<div class="overlay">Megnézem</div>');
        $('.car-box').on('click', function() {
            var content = $(this).clone();
            content.find('.overlay').remove();
            var hiddenInfo = content.find('.hidden-info').html();
            content.find('.hidden-info').remove();
            $('#large-box-content').html(content.html() + hiddenInfo);
            $('#overlay').fadeIn();
            $('#large-box').fadeIn(function() {
                $(this).focus();
            });
        });

        $('#close-btn, #overlay').on('click', function() {
            $('#overlay').fadeOut();
            $('#large-box').fadeOut();
        });


    }

    attachCarBoxListeners();
});
