/**
 * Payment Simulator for Development Environment
 * This script allows simulation of Midtrans payments during development
 * without requiring actual payment transactions.
 */

class PaymentSimulator {
    constructor() {
        this.isDevMode = true; // Set to false in production
        this.originalSnapPay = null;
    }

    /**
     * Initialize the payment simulator
     */
    init() {
        if (!this.isDevMode) return;
        
        // Store original snap.pay function if it exists
        if (window.snap && window.snap.pay) {
            this.originalSnapPay = window.snap.pay;
            this.overrideSnapPay();
        } else {
            // If snap is not loaded yet, wait for it
            this.waitForSnap();
        }
    }

    /**
     * Wait for snap to be loaded and then override it
     */
    waitForSnap() {
        const checkInterval = setInterval(() => {
            if (window.snap && window.snap.pay) {
                this.originalSnapPay = window.snap.pay;
                this.overrideSnapPay();
                clearInterval(checkInterval);
            }
        }, 100);

        // Timeout after 10 seconds
        setTimeout(() => clearInterval(checkInterval), 10000);
    }

    /**
     * Override the snap.pay function with our simulator
     */
    overrideSnapPay() {
        const self = this;
        window.snap.pay = function(snapToken, options) {
            console.log('Payment Simulator: Intercepted snap.pay call');
            console.log('Snap Token:', snapToken);
            
            // Show simulation modal
            self.showSimulationModal(snapToken, options);
        };
        
        console.log('Payment Simulator: Snap.pay successfully overridden');
    }

    /**
     * Show the payment simulation modal
     */
    showSimulationModal(snapToken, options) {
        const modal = this.createModal();
        document.body.appendChild(modal);
        
        const simulateButtons = modal.querySelectorAll('[data-action]');
        simulateButtons.forEach(button => {
            button.addEventListener('click', () => {
                const action = button.getAttribute('data-action');
                this.handleSimulation(action, options);
                document.body.removeChild(modal);
            });
        });
        
        // Close button
        const closeBtn = modal.querySelector('.simulator-close');
        closeBtn.addEventListener('click', () => {
            if (options && options.onClose) {
                options.onClose();
            }
            document.body.removeChild(modal);
        });
    }

    /**
     * Create the simulation modal DOM
     */
    createModal() {
        const modalContainer = document.createElement('div');
        modalContainer.className = 'payment-simulator-modal';
        modalContainer.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            font-family: Arial, sans-serif;
        `;
        
        modalContainer.innerHTML = `
            <div class="simulator-content" style="
                background-color: white;
                border-radius: 8px;
                padding: 20px;
                width: 90%;
                max-width: 500px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            ">
                <div class="simulator-header" style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                    border-bottom: 1px solid #eee;
                    padding-bottom: 10px;
                ">
                    <h2 style="margin: 0; color: #3498db;">Payment Simulator (Development Mode)</h2>
                    <button class="simulator-close" style="
                        background: none;
                        border: none;
                        font-size: 24px;
                        cursor: pointer;
                    ">×</button>
                </div>
                
                <div class="simulator-body">
                    <p style="margin-bottom: 20px;">Pilih salah satu metode pembayaran untuk disimulasikan:</p>
                    
                    <div class="payment-method" style="
                        border: 1px solid #ddd;
                        border-radius: 6px;
                        padding: 15px;
                        margin-bottom: 10px;
                        cursor: pointer;
                    ">
                        <img src="https://placehold.co/120x40/3498db/FFF?text=BNI" alt="BNI" style="height: 40px; margin-bottom: 10px;">
                        <h3 style="margin: 0 0 10px 0;">BNI Mobile Banking</h3>
                        <p style="margin: 0 0 15px 0; color: #666;">Simulate BNI Mobile Banking Payment</p>
                        <div style="display: flex; gap: 10px;">
                            <button data-action="success" style="
                                background-color: #2ecc71;
                                color: white;
                                border: none;
                                padding: 8px 16px;
                                border-radius: 4px;
                                cursor: pointer;
                            ">Success</button>
                            <button data-action="pending" style="
                                background-color: #f1c40f;
                                color: white;
                                border: none;
                                padding: 8px 16px;
                                border-radius: 4px;
                                cursor: pointer;
                            ">Pending</button>
                            <button data-action="error" style="
                                background-color: #e74c3c;
                                color: white;
                                border: none;
                                padding: 8px 16px;
                                border-radius: 4px;
                                cursor: pointer;
                            ">Error</button>
                        </div>
                    </div>

                    <div class="simulator-info" style="
                        background-color: #f8f9fa;
                        border-left: 3px solid #3498db;
                        padding: 10px;
                        margin-top: 20px;
                        font-size: 14px;
                    ">
                        <p style="margin: 0;"><strong>Development Mode:</strong> Pembayaran ini hanya simulasi dan tidak akan memproses transaksi sungguhan.</p>
                    </div>
                </div>
            </div>
        `;
        
        return modalContainer;
    }

    /**
     * Handle the simulation action (success, pending, error)
     */
    handleSimulation(action, options) {
        const mockResult = {
            transaction_time: new Date().toISOString(),
            transaction_status: action === 'success' ? 'settlement' : (action === 'pending' ? 'pending' : 'deny'),
            transaction_id: 'sim-' + Math.random().toString(36).substring(2, 15),
            status_message: action === 'error' ? 'Payment failed due to simulation error' : 'Payment simulated successfully',
            status_code: action === 'success' ? '200' : (action === 'pending' ? '201' : '202'),
            payment_type: 'bank_transfer',
            order_id: 'SIM-ORDER-' + Math.floor(Math.random() * 1000000),
            merchant_id: 'SIM-MERCHANT',
            gross_amount: '10000.00',
            currency: 'IDR',
            _simulated: true
        };
        
        setTimeout(() => {
            console.log('Payment Simulator: Simulating ' + action + ' result', mockResult);
            
            if (action === 'success' && options && options.onSuccess) {
                options.onSuccess(mockResult);
            } else if (action === 'pending' && options && options.onPending) {
                options.onPending(mockResult);
            } else if (action === 'error' && options && options.onError) {
                options.onError(mockResult);
            }
        }, 1000);
    }
}

// Initialize payment simulator when the page loads
document.addEventListener('DOMContentLoaded', () => {
    const simulator = new PaymentSimulator();
    simulator.init();
});