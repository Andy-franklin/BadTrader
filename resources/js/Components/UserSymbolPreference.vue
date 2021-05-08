<template>
    <div class="relative bg-white py-6 px-6 rounded-3xl my-4 shadow-xl">
        <div class="mt-8">
            <p class="text-xl font-semibold my-2">{{ initialData.symbolName }}</p>

            <div class="flex justify-between">
                <div class="text-base text-gray-400 font-semibold">
                    <p>Base Asset: {{ initialData.baseAsset }}</p>
                    <p>Quote Asset: {{ initialData.quoteAsset }}</p>
                </div>
            </div>

            <div class="border-t-2 mb-6 mt-1"></div>

            <div class="flex my-2 justify-between mb-2">
                <div class="w-2/5 mr-4">
                    <p class="font-semibold text-base mb-1">Enabled</p>
                    <checkbox
                        v-model="form.enabled"
                        :disabled="form.processing"
                        :checked="form.enabled === 1"
                        value="enabled"
                    ></checkbox>
                    <p class="font-semibold text-gray-400 mb-2 mt-1">
                        Enabled trading of this asset.
                    </p>
                </div>

                <div class="w-3/5">
                    <p class="font-semibold text-base mb-1">Trading Direction</p>
                    <div class="flex items-center gap-8">
                        <label class="inline-flex items-center">
                            <input
                                type="radio"
                                :name="'tradingDirection' + initialData.symbolName"
                                class="h-5 w-5 text-indigo-700"
                                :disabled="form.disabled"
                                value="Auto"
                                :checked="form.tradingDirection === 'Auto'"
                            />
                            <span class="ml-2 text-gray-700">Auto</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="radio"
                                :name="'tradingDirection' + initialData.symbolName"
                                class="h-5 w-5 text-indigo-700"
                                :disabled="form.disabled"
                                value="Bullish"
                                :checked="form.tradingDirection === 'Bullish'"
                            />
                            <span class="ml-2 text-gray-700">Bullish</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input
                                type="radio"
                                :name="'tradingDirection' + initialData.symbolName"
                                class="h-5 w-5 text-indigo-700"
                                :disabled="form.disabled"
                                value="Bearish"
                                :checked="form.tradingDirection === 'Bearish'"
                            />
                            <span class="ml-2 text-gray-700">Bearish</span>
                        </label>
                    </div>

                    <p class="font-semibold text-gray-400 mb-2 mt-1">
                        Trades will only be opened in the trading direction specified.
                        Leaving the trading direction on auto will mean that the trading algorithm will be free to make a trade in either
                        the buy or sell direction.
                    </p>
                </div>
            </div>

            <div class="flex my-2 justify-between mb-2">
                <div class="w-2/5 mr-4">
                    <p class="font-semibold text-base mb-1">FIAT Max Allocation</p>
                    <breeze-input
                        :disabled="form.processing"
                        id="fiat_max_allocation"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.fiat_max_allocation"
                        required
                    />
                    <p class="font-semibold text-gray-400 mb-2 mt-1">
                        How much value (in your default FIAT currency) the algorithm can allocate to open trades.
                    </p>
                </div>

                <div class="w-3/5">
                    <p class="font-semibold text-base mb-1">Cooling off period</p>
                    <breeze-input
                        :disabled="form.processing"
                        id="cool_off_period"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.cool_off_period"
                        required
                    />
                    <p class="font-semibold text-gray-400 mb-2 mt-1">
                        How many minutes the should algorithm wait before making another trade after an unsuccessful trade.
                        By default the algorithm chosen will have its own default cooling off period set.
                    </p>
                </div>
            </div>
        </div>

        <breeze-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="saveSettings">
            Save Preferences
        </breeze-button>
        <div class="clear-both"></div>
    </div>

</template>

<script>
    import Radio from "./Radio";
    import Checkbox from "./Checkbox";
    import Input from "./Input";
    import BreezeInput from '@/Components/Input'
    import BreezeButton from '@/Components/Button'

    export default {
        name: "UserSymbolPreference",
        components: {
            Input,
            Checkbox,
            Radio,
            BreezeInput,
            BreezeButton
        },
        props: {
            userSymbolPreference: {
                type: Object
            },
            emptyPreference: {
                type: Object
            }
        },
        data: function () {
            return {
                initialData: {},
                form: {
                    processing: false,
                    enabled: false,
                    tradingDirection: 'Auto',
                    fiat_max_allocation: 100,
                    cool_off_period: 0
                },
                tradingDirection: ['Auto', 'Bullish', 'Bearish'],
            }
        },
        mounted() {
            this.form.tradingDirection = 'Auto';

            if (this.userSymbolPreference !== undefined) {
                this.form.processing = false;
                this.form.enabled = this.userSymbolPreference.enabled;
                this.form.fiat_max_allocation = this.userSymbolPreference.fiat_max_allocation;
                this.form.cool_off_period = this.userSymbolPreference.cool_off_period;
                this.form.symbol = this.userSymbolPreference.symbol_id;

                this.initialData = this.userSymbolPreference;
                if (this.initialData.bullish) {
                    this.form.tradingDirection = 'Bullish';
                } else if (this.initialData.bearish) {
                    this.form.tradingDirection = 'Bearish';
                }
            } else {
                this.initialData = this.emptyPreference;
                this.form.symbol = this.initialData.id;
            }
        },
        methods: {
            saveSettings: function () {
                let tradingDirection = 'auto';
                let ele = document.getElementsByName('tradingDirection' + this.initialData.symbolName);
                for (let i = 0; i < ele.length; i++) {
                    if (ele[i].checked) {
                        tradingDirection = ele[i].value;
                    }
                }

                this.form.bullish = false;
                this.form.bearish = false;

                if (tradingDirection === 'Bullish') {
                    this.form.bullish = true;
                }
                if (tradingDirection === 'Bearish') {
                    this.form.bearish = true;
                }
debugger;
                axios.post(route('dashboard.options.update', {'symbol': this.form.symbol}), {
                    'enabled': this.form.enabled,
                    'fiat_max_allocation': this.form.fiat_max_allocation,
                    'cool_off_period': this.form.cool_off_period,
                    'bearish': this.form.bearish,
                    'bullish': this.form.bullish
                }).then(function () {
                    alert('hi')
                });
            }
        }
    }
</script>

<style scoped>
    #disabled {
        border-radius: 1.5rem;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background-color: #1a202c;
        opacity: 0.2;

    }
</style>
