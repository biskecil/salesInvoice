require("./bootstrap");
import autoComplete from "@tarekraafat/autocomplete.js";
import AutoNumeric from "autonumeric";
import Decimal from "decimal.js";

window.Decimal = Decimal;
window.AutoNumeric = AutoNumeric;

document.addEventListener("DOMContentLoaded", () => {
    const input = document.querySelector("#cariDataNota");
    if (!input) return; 

    const autoCompleteJS = new autoComplete({
        selector: "#cariDataNota",
        placeHolder: "Cari Nota",
        data: {
            src: async () => {
              const query = document.querySelector("#cariDataNota").value;
              try {
                const source = await fetch(`/sales/getData/Nota/search?q=${query}`);
                const data = await source.json();
                return data.map(item => item.invoice_number);
              } catch (error) {
                return [];
              }
            },
            cache: false
          },
        resultItem: {
            highlight: true
        },
        events: {
            input: {
                selection: (event) => {
                    const selection = event.detail.selection.value;
                    autoCompleteJS.input.value = selection;
                }
            }
        }
    });
});

