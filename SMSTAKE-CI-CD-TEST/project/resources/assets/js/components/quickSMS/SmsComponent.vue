<template>
    <div class="phoneCounter">
        <textarea name="numbers"
                  id="numbers"
                  v-model="number"
                  @keydown="countNumbers(this)"></textarea>
        <div>{{ Phone }}</div>
        <strong>{{ this.numberCount }}</strong>
    </div>
</template>

<script>
    export default {
        props:{
            numberValue:{ type: String, default: ""}
        },

        data() {
            return {
                Phone: 'Phone Number',
                numberCount: 0
            }
        },

        computed: {
            number: {
                get() {return this.numberValue},
                set(v){ this.$emit("input", v)}
            }
        },

        methods: {
            countNumbers(event) {
                console.log('test'+ event.currentTarget.id);
//                this.numberCount = event.target.value.length;
//                alert(this.numberCount);
            }
        }
    }
</script>
