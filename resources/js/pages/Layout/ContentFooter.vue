<template>
    <footer class="footer">
        <modal :show.sync="infos">
            <template slot="header">
                Ce projet est réalisé en colloboration avec les Junior Entreprises suivantes :
            </template>
            <template>
                <!-- <div class="row align-items-center">
                    <div class="col-md-4">
                        <a href="https://www.facebook.com/optimajuniorentreprise/" target="_blank">
                            <img src="/images/optima.png" style="width:140px">
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="https://www.facebook.com/junior.entreprise.insat/" target="_blank">
                            <img src="/images/insat.png" style="width:120px">
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="https://www.facebook.com/ENSI.Junior.Entreprise/" target="_blank">
                            <img src="/images/ensi.png" style="width:90px">
                        </a>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6" style="padding-top: 10px;">
                        <a href="https://www.facebook.com/SMA.Juniorentreprise/?ref=br_rs" target="_blank">
                            <img src="/images/sma.png" style="width:100px">
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="https://www.facebook.com/OrendaJE/" target="_blank">
                            <img src="/images/orenda.png" style="width:120px">
                        </a>
                    </div>
                </div> -->
            </template>

            <template slot="footer">
                <base-button type="secondary" @click="infos = false;"
                >Fermer
                </base-button
                >

            </template>
        </modal>
        <!-- <ul class="nav">
            <li class="nav-item">
                <a href="#" v-on:click.prevent="infos=true;" class="nav-link" style="color: #ba54f5">
                    Les juniors Entreprises participantes
                </a>
            </li>
        </ul> -->
        <div class="container-fluid">
            <div class="copyright" style="margin-right: 120px">
                &copy;
                {{ new Date().getFullYear() }} made with <i class="tim-icons icon-heart-2"></i> by
                <a href="https://optimaje.com/" target="_blank">Optima Junior Entreprise</a>.
            </div>
        </div>
    </footer>

</template>
<script>
    import {Modal} from "../../components/index";

    export default {
        components: {Modal},
        data() {

            return {
                infos: false
            }
        },
        methods: {
            disableRTL() {
                if (!this.$rtl.isRTL) {
                    this.$rtl.disableRTL();
                }
            },
            toggleNavOpen() {
                let root = document.getElementsByTagName('html')[0];
                root.classList.toggle('nav-open');
            }
        },
        mounted() {
            this.$watch('$route', this.disableRTL, {immediate: true});
            this.$watch('$sidebar.showSidebar', this.toggleNavOpen)
        }
    };
</script>
<style>
</style>
