async function fetchDataFromAPI() {
    try {
        const response = await fetch('/sales/getData/Nota/search'); 
        if (!response.ok) throw new Error('API error');
        const data = await response.json();
     
        return data.map(item => item.invoice_number);
    } catch (err) {
        console.error(err);
        return [];
    }
}

// === fungsi autocomplete (semua event listener tetap di sini) ===
function createAutocomplete(inputId, suggestionBoxId, dataArray) {
    const input = document.getElementById(inputId);
    const suggestionBox = document.getElementById(suggestionBoxId);

    function showSuggestions(list) {
        suggestionBox.innerHTML = '';
        if (list.length === 0) {
            suggestionBox.style.display = 'none';
            return;
        }

        list.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item;
            li.classList.add('list-group-item', 'list-group-item-action');
            li.style.cursor = 'pointer';
            li.addEventListener('click', function() {
                input.value = item;
                suggestionBox.style.display = 'none';
            });
            suggestionBox.appendChild(li);
        });

        suggestionBox.style.display = 'block';
    }

    // filter saat user ketik
    input.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        if (!query) {
            suggestionBox.style.display = 'none';
            return;
        }
        const filtered = dataArray.filter(item => item.toLowerCase().includes(query));
        showSuggestions(filtered);
    });

    // saat focus → tampilkan 5 terakhir
    input.addEventListener('focus', function() {
        if (!this.value) {
            const lastFive = dataArray.slice().reverse().slice(0,5);
            showSuggestions(lastFive);
        }
    });

    // hide kalau klik di luar
    document.addEventListener('click', function(e) {
        if (!suggestionBox.contains(e.target) && e.target !== input) {
            suggestionBox.style.display = 'none';
        }
    });
}

// === inisialisasi ===
(async function init() {
    const dataArray = await fetchDataFromAPI();
    createAutocomplete("cariDataNota", "notaSuggestions", dataArray);
})();
