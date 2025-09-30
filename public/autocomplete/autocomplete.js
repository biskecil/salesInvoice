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
    let currentIndex = -1; // index suggestion yang dipilih

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

    // // saat focus → tampilkan 5 terakhir
    // input.addEventListener('focus', function() {
    //     if (!this.value) {
    //         const lastFive = dataArray.slice().reverse().slice(0,5);
    //         showSuggestions(lastFive);
    //     }
    // });

    input.addEventListener('keydown', function (e) {
        const items = suggestionBox.querySelectorAll('li');
        if (items.length === 0) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentIndex = (currentIndex + 1) % items.length;
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentIndex = (currentIndex - 1 + items.length) % items.length;
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (currentIndex >= 0 && currentIndex < items.length) {
                input.value = items[currentIndex].textContent;
                suggestionBox.style.display = 'none';
            }
        }

        items.forEach((item, idx) => {
            if (idx === currentIndex) {
                item.classList.add('active'); // bootstrap sudah ada style untuk .active
            } else {
                item.classList.remove('active');
            }
        });
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
