<template>
    <div class="content">
        <card>
            <template slot="header">
                <h5 class="title">{{!ar ?'Liste des demandes' : 'قائمة&nbsp;الطلبات'}}</h5>
                <div class="row filtre">
                    <div class="col-sm-4">
                        <base-input :label="!ar ? 'Filtrer par gouvernorat' : ' تصفية حسب الولاية'">
                            <select class="form-control " @change="onFiltreGouvernoratChange($event)" v-model="filtre"
                            >
                                <option v-for="(gouvernorat, index) in gouvernorats"
                                        :value="gouvernorat.fr"
                                        :key="index"
                                >{{!ar ? gouvernorat.fr : gouvernorat.ar}}
                                </option>
                            </select>
                        </base-input>
                    </div>
                    <div class="col-sm-8">
                        <base-button  style="    margin-top: 23px;" type="warning" fill
                                     v-on:click="onFiltreAll()">{{!ar ? 'Afficher tous' : 'إظهار الكل'}}
                        </base-button>
                    </div>

                </div>
            </template>
            <div class="table-responsive">
                <table class="table tablesorter text-left">
                    <thead class="text-primary">
                    <tr>
                        <slot nom="columns">
                            <th>{{!ar ? 'Listes des demandes' : 'قائمة&nbsp;الطلبات'}}</th>
                            <th>{{!ar ? 'Description' : 'تفاصيل'}}</th>
                            <th>{{!ar ? 'Gouvernorat' : 'الولاية'}}</th>
                            <th>{{!ar ? 'Téléphone' : 'الهاتف'}}</th>
                            <th></th>
                        </slot>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="loading">
                        <td colspan="7">
                            <div class="login text-center"><i class="tim-icons  icon-refresh-02 rotating"></i></div>
                        </td>
                    </tr>
                    <tr v-for="(article, index) in filtredArticles"
                        :key="index"
                    >
                        <td>{{article.nom}}</td>
                        <td>{{article.description | truncate(6, '...') }}<a href="#"
                                                                            v-on:click.prevent="openMore(article);modals.demandeModal=true">
                            {{ !ar ? ' lire la suite' : 'اقرأ المزيد'}}
                        </a></td>

                        <td>{{article.user.gouvernorat}}</td>
                        <td>{{article.user.telephone}}</td>
                        <td>
                            <router-link :to="'/don?ar='+ar">
                                <base-button type="warning" fill>{{!ar ?'Faire un don' : 'التبرع'}}</base-button>
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <template slot="footer">
                <!-- <base-button type="success" fill v-on:click="saveDon()">Entregistrer</base-button> -->
            </template>
        </card>
        <modal :show.sync="modals.demandeModal">
            <template slot="header">
                {{!ar ? 'Description' : 'تفاصيل'}}
            </template>
            <template>
                <div :class="!ar ? 'text-left' : 'text-right'">
                    <p>
                        {{this.selectedArticle.description}}
                    </p>
                </div>
            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.demandeModal = false;"
                >{{!ar ? 'Fermer' : 'اغلاق'}}
                </base-button>
            </template>
        </modal>

    </div>

</template>
<script>
    import {
        Card,
        BaseInput
    } from "../../../components/index";

    import BaseButton from '../../../components/BaseButton';
    import BaseTable from "../../../components/BaseTable";
    import {Modal} from "../../../components/index";

    export default {
        components: {
            Card,
            BaseInput,
            BaseButton,
            BaseTable,
            Modal
        },
        data() {
            return {
                modals: {
                    demandeModal: false,
                },
                loading: true,
                selectedArticle: {},
                filtre: ''
            }
        },
        methods: {
            openMore(article) {
                this.selectedArticle = article;
            },
            onFiltreGouvernoratChange(event) {
                this.filtredArticles = this.articles.filter(function (el) {
                    return el.user.gouvernorat == event.target.value
                });
            },
            onFiltreAll() {
                this.filtre = '';
                this.filtredArticles = this.articles;
            }


        },
        mounted() {
            this.$store.commit('toggleRefresh', false);
            this.$store.dispatch('getArticles')
                .then((response) => {
                    this.loading = false;
                });
        },
        computed: {
            ar() {
                if (this.$route.query.ar)
                    return this.$route.query.ar
                return '';
            },
            articles: {
                get() {
                    return this.$store.getters.articles;
                },
            },
            filtredArticles: {
                get() {
                    return this.$store.getters.filtredArticles;
                },
                set(value) {
                    this.$store.commit('setFiltredArticles', JSON.stringify(value));
                },
            },
            gouvernorats() {
                return this.$store.getters.gouvernorats
            }

        }
    }
</script>
<style scoped>
    @media screen and (min-width: 768px) {
        .content {
            padding: 120px;
        }
    }

    .noneBg {
        background: transparent !important;
    }

    .traite {
        background: #32ff7e;
    }

    .encours {
        background: #18dcff;
    }

    .nontraite {
        background: #ff8d72;
    }

    .tim-icons .icon-single-02 {
        color: black !important;
    }

    .input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
        border-color: rgba(29, 37, 59, 0.5) !important;
    }
</style>
