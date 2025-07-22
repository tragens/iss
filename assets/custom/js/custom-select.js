document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("select.customSelect").forEach(originalSelect => {
    const ajaxUrl = originalSelect.dataset.ajaxUrl || null;

    const wrapper = document.createElement("div");
    wrapper.className = "custom-select-wrapper";

    const display = document.createElement("div");
    display.className = "custom-select-display";
    display.textContent = originalSelect.options[originalSelect.selectedIndex]?.text || "Select";

    const dropdown = document.createElement("div");
    dropdown.className = "custom-select-dropdown";

    const searchBox = document.createElement("div");
    searchBox.className = "custom-select-search";
    const input = document.createElement("input");
    input.type = "text";
    input.placeholder = "Search...";
    searchBox.appendChild(input);

    const optionsContainer = document.createElement("div");
    optionsContainer.className = "custom-select-options";

    function createOption(text, value) {
      const opt = document.createElement("div");
      opt.className = "custom-select-option";
      opt.textContent = text;
      opt.dataset.value = value;

      opt.addEventListener("click", () => {
        display.textContent = text;

        // Ensure the value exists in the original <select>
        let found = [...originalSelect.options].some(o => o.value === value);
        if (!found) {
          const newOption = new Option(text, value, true, true);
          originalSelect.add(newOption);
        }

        originalSelect.value = value;
        originalSelect.dispatchEvent(new Event("change"));
        dropdown.style.display = "none";
      });

      return opt;
    }


    // If no AJAX, load static options
    if (!ajaxUrl) {
      Array.from(originalSelect.options).forEach(option => {
        const customOption = createOption(option.textContent, option.value);
        optionsContainer.appendChild(customOption);
      });
    }

    dropdown.appendChild(searchBox);
    dropdown.appendChild(optionsContainer);
    wrapper.appendChild(display);
    wrapper.appendChild(dropdown);
    originalSelect.style.display = "none";
    originalSelect.parentNode.insertBefore(wrapper, originalSelect);
    wrapper.appendChild(originalSelect);

    display.addEventListener("click", () => {
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
      input.value = "";
      if (!ajaxUrl) filterOptions("");
      input.focus();
    });

    input.addEventListener("input", () => {
      const term = input.value.trim().toLowerCase();
      if (ajaxUrl) {
        if (term.length < 1) {
          optionsContainer.innerHTML = '';
          return;
        }

        const params = new URLSearchParams();
        params.append("search", term);

        // Dynamically include all data-* attributes as additional parameters
        for (const attr of originalSelect.attributes) {
          if (attr.name.startsWith("pass-data-") && attr.name !== "data-ajax-url") {
            const key = attr.name.replace("pass-data-", "");
            params.append(key, attr.value);
          }
        }

        fetch(`${ajaxUrl}?${params.toString()}`)
          .then(res => res.json())
          .then(data => {
            optionsContainer.innerHTML = '';
            if (data.customer) {
              data.customer.forEach(item => {
                const opt = createOption(item.label, item.value);
                optionsContainer.appendChild(opt);
              });
            }
          })
          .catch(err => console.error("AJAX error:", err));
      } else {
        filterOptions(term);
      }
    });

    function filterOptions(filter) {
      optionsContainer.querySelectorAll(".custom-select-option").forEach(opt => {
        const text = opt.textContent.toLowerCase();
        opt.style.display = text.includes(filter) ? "block" : "none";
      });
    }

    document.addEventListener("click", e => {
      if (!wrapper.contains(e.target)) {
        dropdown.style.display = "none";
      }
    });

    // Dispatch init event
    originalSelect.dispatchEvent(new CustomEvent("custom-select:initialized", {
      detail: { select: originalSelect }
    }));
  });
});


