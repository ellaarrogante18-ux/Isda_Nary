import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Fish price calculator
window.calculateTotal = function() {
    const quantity = parseFloat(document.getElementById('quantity_sold')?.value) || 0;
    const pricePerKilo = parseFloat(document.getElementById('price_per_kilo')?.value) || 0;
    const totalElement = document.getElementById('total_price');
    
    if (totalElement) {
        totalElement.textContent = '₱' + (quantity * pricePerKilo).toFixed(2);
    }
};

// Get fish price when fish is selected
window.getFishPrice = function(fishId) {
    if (!fishId) return;
    
    fetch(`/fish/${fishId}/price`)
        .then(response => response.json())
        .then(data => {
            const priceInput = document.getElementById('price_per_kilo');
            const stockInfo = document.getElementById('stock_info');
            const quantityInput = document.getElementById('quantity_sold');
            
            if (priceInput) {
                priceInput.value = data.price_per_kilo;
            }
            
            if (stockInfo) {
                stockInfo.textContent = `Available: ${data.available_stock} kg`;
                stockInfo.className = data.available_stock > 0 ? 'text-green-600 text-sm' : 'text-red-600 text-sm';
            }
            
            if (quantityInput) {
                quantityInput.max = data.available_stock;
            }
            
            calculateTotal();
        })
        .catch(error => {
            console.error('Error fetching fish price:', error);
        });
};

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Confirm delete actions
window.confirmDelete = function(message = 'Are you sure you want to delete this item?') {
    return confirm(message);
};

// Format currency inputs
document.addEventListener('DOMContentLoaded', function() {
    const currencyInputs = document.querySelectorAll('.currency-input');
    currencyInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d.]/g, '');
            if (value) {
                e.target.value = parseFloat(value).toFixed(2);
            }
        });
    });
});

// Mobile menu toggle
window.toggleMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
};
