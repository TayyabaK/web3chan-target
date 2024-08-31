import { AlpineComponent } from 'alpinejs';
import * as solanaWeb3 from '@solana/web3.js';

interface Wallet {
    balance: number;
    walletAddress: string | null;
    init(): void;
    connectWallet(): void;
    isPhantomInstalled(): boolean;
    login(): void;
    getProvider(): Promise<any>;
    retrieveBalance(): void;
}

const phantomWalletInstance: Wallet | AlpineComponent<Wallet> = {
    balance: 0,
    walletAddress: null, // Initialize walletAddress to null

    init() {
        this.$nextTick(() => {
            console.log('Phantom Wallet Component Initialized');

            // Check if public key exists in localStorage
            const storedPublicKey = localStorage.getItem('phantomWalletPublicKey');
            if (storedPublicKey) {
                this.walletAddress = storedPublicKey;
            }

            window.addEventListener('tipPostAuthor', (e: CustomEvent) => {
                console.log('Tip event received', e.detail);
                if (e.detail.amount > 0) {
                    alert('Tip sent to author: ' + e.detail.amount + ' SOL');
                }
            });
        });
    },

    connectWallet() {
        this.login();
        this.retrieveBalance();
    },

    isPhantomInstalled() {
        const isPhantomInstalled = window.solana && window.solana.isPhantom;

        if (!isPhantomInstalled) {
            alert('Phantom wallet is not installed');
            return false;
        }

        console.log('Phantom wallet is installed');
        return true;
    },

    async login() {
        if (!this.isPhantomInstalled()) {
            return;
        }

        try {
            const resp = await window.solana.connect();
            const publicKey = resp.publicKey.toString();
            console.log('Account: ' + publicKey);

            // Store the public key in localStorage
            localStorage.setItem('phantomWalletPublicKey', publicKey);
            this.walletAddress = publicKey;
            console.log('Public key stored in localStorage: ' + publicKey);
        } catch (err) {
            console.log('User rejected request');
            console.log(err);
        }
    },

    async getProvider() {
        if (!this.isPhantomInstalled()) {
            return;
        }

        await window.solana.connect();
        return await window.solana;
    },

    async retrieveBalance() {
        this.isPhantomInstalled();
        if (!this.isPhantomInstalled()) {
            console.log('Phantom wallet is not installed so cannot show balance');
            return;
        }

        let provider = await this.getProvider();
        let connection = new solanaWeb3.Connection(solanaWeb3.clusterApiUrl('devnet'), 'confirmed');
        console.log('Connected to cluster', connection);
        console.log('Provider', provider);

        connection.getBalance(provider.publicKey).then((value) => {
            console.info('Balance: ' + value / 1000000000 + ' SOL');
            this.balance = value / 1000000000;
        });
    },
};

export default (Alpine) => {
    Alpine.data('phantomWalletComponent', () => ({ ...phantomWalletInstance }));
};
