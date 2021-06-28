<template>
<div class="content">
  <card>
    <template slot="header">
        <div ref="foo">
        <ul v-if="filtres.type != '' || filtres.gouvernorat != '' || filtres.universite != '' || filtres.etablissement != '' || filtres.formation != '' || filtres.diplome != '' || filtres.specialite != '' || filtres.mention != ''">
            <li v-if="filtres.type"><strong style="padding-right: 10px">{{this.lang_dict[this.lang_select].etablissements}} {{filtres.type == 'prive' ? 'Privés' : 'Publiques'}} </strong></li>
            <li v-if="filtres.gouvernorat"><strong style="padding-right: 10px">{{this.lang_dict[this.lang_select].gouvernorat}}: </strong> {{ filtres.gouvernorat }}</li>
            <li v-if="filtres.universite"><strong style="padding-right: 10px">{{this.lang_dict[this.lang_select].universite}}: </strong> {{ all_universites.find(element => element.id ==  filtres.universite) ? translate(all_universites.find(element => element.id ==  filtres.universite)): '' }}</li>
            <li v-if="filtres.etablissement"><strong style="padding-right: 10px">{{this.lang_dict[this.lang_select].etablissement}}: </strong>{{ etablissements.find(element => element.id ==  filtres.etablissement) ? translate(etablissements.find(element => element.id ==  filtres.etablissement)) : '' }}</li>
            <li v-if="filtres.formation"><strong style="padding-right: 10px">{{this.lang_dict[this.lang_select].formation}}: </strong> {{ domaines.find(element => element.id ==  filtres.formation) ? translate(domaines.find(element => element.id ==  filtres.formation)) : '' }}</li>
            <li v-if="filtres.diplome"><strong style="padding-right: 10px">{{this.lang_dict[this.lang_select].diplome}}: </strong> {{ diplomes.find(element => element.id ==  filtres.diplome) ? translate(diplomes.find(element => element.id ==  filtres.diplome)) : '' }}</li>
            <li v-if="filtres.specialite"><strong style="padding-right: 10px">{{this.lang_dict[this.lang_select].specialite}}: </strong> {{specialites.find(element => element.id ==  filtres.specialite) ? translate(specialites.find(element => element.id ==  filtres.specialite)) : '' }}</li>
            <li v-if="filtres.mention"><strong style="padding-right: 10px"{{this.lang_dict[this.lang_select].mention}}>: </strong> {{ mentions.find(element => element.id ==  filtres.mention) ?  translate(mentions.find(element => element.id ==  filtres.mention)) : ''  }}</li>
        </ul>
        <h3 v-else>{{this.lang_select ? 'كل الكليات' : 'Toutes les universités'}}</h3>
        </div>
      <div class="row filtre">
         <div class="col-sm-3">
              <base-button style=" margin-bottom: 20px !important;" type="info" fill v-on:click="modals.filtres = true;">Rechercher</base-button>
        </div>
        <div class="col-sm-9">
            <drop-down tag="div" class="exportBtn">
                <button aria-label="Success" data-toggle="dropdown" class="dropdown-toggle btn-rotate btn btn-success">
                    Exporter
                </button>
                <ul class="dropdown-menu">
                    <a href="#" class="dropdown-item" v-on:click="generatePdf()">PDF</a>
                    <a href="#" class="dropdown-item" v-on:click="generateExcel()">Excel</a>
                    <a href="#" class="dropdown-item" v-on:click="generateCSV()">CSV</a>
                </ul>
            </drop-down>
        </div>
      </div>
    </template>
        <div class="table-responsive">
        <table class="table text-left holderTable" ref="content"  :style="lang_select ? 'text-align: right !important' : ''">
            <thead class="text-primary">
            <tr>
                <slot name="columns">
                <th>{{this.lang_dict[this.lang_select].etablissements}}</th>
                <th>{{this.lang_dict[this.lang_select].diplome}}</th>
                <th>{{this.lang_dict[this.lang_select].specialite}}</th>
                <th>{{this.lang_dict[this.lang_select].mention}}</th>
                <th>{{this.lang_dict[this.lang_select].duree}}</th>
                </slot>
            </tr>
            </thead>
            <tbody >
              <tr v-if="loading">
                <td colspan="6" >
                  <div class="login text-center"><i class="tim-icons  icon-refresh-02 rotating"></i></div>
                </td>
              </tr>
            <tr v-if="universites.length == 0">
                <td colspan="7">
                    <div class="login text-center">
                        Aucune donnée disponible...
                    </div>
                </td>
            </tr>
                <template v-for="(universite) in universites"
                       >
                <tr :key="universite.id">
                    <td colspan="5" class="titleTable"> <h4>{{lang_select ? universite.titre_ar : universite.titre}}</h4></td>
                </tr>
                 <template  v-for="(etablissement) in universite.etablissements"
                       >
                    <tr v-for="(specialite, index3) in etablissement.specialites" :key="index3+etablissement.titre+specialite.titre">
                        <td style="border-right: 0.0625rem solid #e3e3e3; width: 300px;" v-if="index3 == 0" :rowspan="etablissement.specialites.length">{{lang_select ? etablissement.titre_ar : etablissement.titre}}</td>
                        <td>{{specialite.diplome ? (lang_select ? specialite.diplome.titre_ar : specialite.diplome.titre) : ''}}</td>
                        <td>{{ lang_select ? specialite.titre : specialite.titre_ar }}</td>
                        <td>{{specialite.mention ?  (lang_select ? specialite.mention.titre_ar : specialite.mention.titre) : ''}}</td>
                        <td> {{specialite.pivot ? specialite.pivot.habilitation_debut : ''}}</td>
                    </tr>
                 </template>  
              </template>   
            </tbody>
        </table>
        </div>

    <template slot="footer">
      <!-- <base-button type="success" fill v-on:click="saveDon()">Entregistrer</base-button> -->
    </template>
  </card>
		<modal :show.sync="modals.filtres" class="text-left" modalClasses="modal-lg">
			<template slot="header">
				Filtrer l'affichage
			</template>

			<template>
            <div class="row filtre">
                    <div class="col-sm-6">
                        <base-input label="Par université">
                            <select
                                class="form-control"  @change="onChangeUniversite($event)" v-model="filtres.universite"
                            >
                                <option value="" selected>Toutes les universités</option>
                                <option
                                    v-for="(universite, index) in all_universites"
                                    :value="universite.id"
                                    :key="index"
                                    >{{ universite.titre }}</option
                                >
                            </select>
                        </base-input>
                    </div>
                    <div class="col-sm-6">
                        <base-input label="Par Etablissement">
                            <select
                                class="form-control" v-model="filtres.etablissement"
                            >
                                <option value="" selected>Tous les etablissements</option>
                                <option
                                    v-for="(etablissement, index) in etablissements"
                                    :value="etablissement.id"
                                    :key="index"
                                    >{{ etablissement.titre }}</option
                                >
                            </select>
                        </base-input>
                    </div>
                    <div class="col-sm-4">
                        <base-input label="Par gouvernorat">
                            <select
                                class="form-control"   v-model="filtres.gouvernorat"
                            >
                                <option value=""  selected>Tous les gouvernorats</option>
                                <option
                                    v-for="(gouvernorat, index) in gouvernorats"
                                    :value="gouvernorat.fr"
                                    :key="index"
                                    >{{ gouvernorat.fr }}</option
                                >
                            </select>
                        </base-input>
                    </div>
                    <div class="col-sm-4">
                        <base-input label="Type d'etablissement">
                        <select class="form-control "   v-model="filtres.type"
                        >
                            <option value=""  selected>Tout type d'etablissement</option>
                            <option v-for="(type, index) in types"
                                    :value="type.value" 
                                    :key="index"
                                    >{{type.label}}</option>
                                >
                            </select>
                        </base-input>
                    </div>      
                    <div class="col-sm-4">
                    <base-input  label="Recherche par Formation">
                        <select class="form-control "   v-model="filtres.formation"
                        >
                            <option value=""  selected>Toutes les formations</option>
                            <option v-for="(domaine, index) in domaines"
                                    :value="domaine.id" 
                                    :key="index"
                                    >{{domaine.titre}}</option>
                        </select>
                    </base-input>
                    </div>
                
                    <div class="col-sm-4">
                    <base-input  label="Recherche par Diplome">
                        <select class="form-control "   v-model="filtres.diplome" 
                        >
                            <option value=""  selected>Tous les Diplomes</option>
                            <option v-for="(domaine, index) in diplomes"
                                    :value="domaine.id" 
                                    :key="index"
                                    >{{domaine.titre}}</option>
                        </select>
                    </base-input>
                    </div>
                    <div class="col-sm-4">
                    <base-input  label="Recherche par Spécialité">
                        <select class="form-control "   v-model="filtres.specialite"
                        >
                            <option value=""  selected>Toutes les Spécialtiés</option>
                            <option v-for="(specialite, index) in specialites"
                                    :value="specialite.id" 
                                    :key="index"
                                    >{{specialite.titre}}</option>
                        </select>
                    </base-input>
                    </div>
                    <div class="col-sm-4">
                    <base-input  label="Recherche par Mention">
                        <select class="form-control "    v-model="filtres.mention"
                        >
                            <option value=""  selected>Toutes les mentions</option>
                            <option v-for="(domaine, index) in mentions"
                                    :value="domaine.id" 
                                    :key="index"
                                    >{{domaine.titre}}</option>
                        </select>
                    </base-input>
                    </div>

                    <div class="col-sm-2">
                        <base-button size="sm" style="margin-top: unset !important; margin-bottom: 20px !important;" type="info" fill v-on:click="reset()">Réinitialiser les filtres</base-button>
                    </div>
                </div>


			</template>
			<template slot="footer">
				<base-button type="primary" @click="modals.filtres = false">Fermer</base-button>
                <base-button type="warning" fill v-on:click="onFiltreAll()">Rechercher</base-button>
			</template>



		</modal>

 </div>
 
</template>
<script>

import {
  Card,
  BaseInput,
  BaseAlert
} from "../components/index";

import BaseButton from '../components/BaseButton';
import BaseTable from "../components/BaseTable";
import { Modal } from "../components/index";
export default{
  components:{
    Card,
    BaseInput,
    BaseButton,
    BaseTable,
    BaseAlert,
    Modal
  },
  data() {
    return {
        modals:{
            donModal: false,
            acteurModal: false,
            newUser: false,
            deleteUser: false,
            filtres: false
        },
      lang_dict:[{
            etablissements: 'Etablissemnts',
            diplome: 'Diplome',
            specialite: 'Spécialité',
            mention: 'Mention',
            duree: "Durée d'habilitation",
            gouvernorat: 'Gouvernorat',
            universite: 'Université',
            etablissement: 'Etablissement',
            formation: 'Formation'
            },
            
            {
            etablissements: 'الكليات',
            diplome: 'الشهادة',
            specialite: 'تخصص',
            mention: 'Mention',
            duree: "فترة التفويض",
            Gouvernorat: 'الولاية',
            universite: 'الجامعة',
            etablissement: 'الكلية',
            formation: 'تكوين'
            }
      ],
      lang_select: 0,
      loading: true,
      filtres: {
          formation: '',
          diplome: '',
          mention: '',
          specialite: '',
          type: '',
          gouvernorat: '',
          universite: '',
          etablissement: ''
      },
      types:[{
          value: 'publique',
          label: 'Publique'
          },
          {
              value: 'prive',
              label: 'Privé'
          }]
          
    }
 },
 methods:{
        translate:function(data){
            if(this.lang_select)
                return data.titre_ar;
            return data.titre;
        },
        onFiltreGouvernoratChange(event){
          this.filtredUsers = this.users.filter(function (el) {
            return el.gouvernorat == event.target.value
          });
        },
        onChangeUniversite(event){
          if(event.target.value != ''){
            this.$store.dispatch("getEtablissements", "universite="+event.target.value).then(response => {
            });
            this.filtres.etablissement = "";
          }else{
             this.$store.dispatch("getEtablissements", "").then(response => {});
          }

        },
        reset(){
            this.modals.filtres = false;
            this.loading = true;
            this.filtres = {
                formation: '',
                diplome: '',
                mention: '',
                specialite: '',
                type: '',
                gouvernorat: '',
                universite: '',
                etablissement: ''
            };
            this.$store.dispatch("getUniversites", '').then(response => {
                this.loading = false;
            }); 
            this.$store.dispatch("getEtablissements", "").then(response => {
            });
        },
        onFiltreAll(){
            this.modals.filtres = false;
            this.loading = true;
            let filtre = '';
            // if(this.filtres.formation != '' || this.filtres.mention != '' || this.filtres.specialite != '' || this.filtres.diplome != '' ||  this.filtres.type != ''){
                if(this.filtres.gouvernorat != ''){
                    filtre += 'gouvernorat='+this.filtres.gouvernorat+'&';
                }
                if(this.filtres.type != ''){
                    filtre += 'type='+this.filtres.type+'&';
                }
                if(this.filtres.formation != ''){
                    filtre += 'formation='+this.filtres.formation+'&';
                }
                    
                if(this.filtres.mention != ''){
                    filtre += 'mention='+this.filtres.mention+'&';   
                }
                    
                if(this.filtres.specialite != ''){
                    filtre += 'specialite='+this.filtres.specialite+'&';
                }
                    
                if(this.filtres.diplome != ''){
                    filtre += 'diplome='+this.filtres.diplome+'&';
                }

                if(this.filtres.universite != ''){
                    filtre += 'universite='+this.filtres.universite+'&';
                }

                if(this.filtres.etablissement != ''){
                    filtre += 'etablissement='+this.filtres.etablissement+'&';
                }

                this.$store.dispatch("getUniversites", filtre).then(response => {
                    this.loading = false;
                });         
            // }

         },
         generatePdf(){
            // const doc = new jsPDF();
            // /** WITH CSS */
            // var canvasElement = document.createElement('canvas');
            // canvasElement.style.width = '800px';
            //     html2canvas(this.$refs.content, { canvas: canvasElement 
            //     }).then(function (canvas) {
            //     const img = canvas.toDataURL("image/jpeg", 0.8);
            //     doc.addImage(img,'JPEG',20,20);
            //     doc.save("sample.pdf");
            // });
             const template = this.$refs.foo.innerHTML;
            this.$store.dispatch('generatePDF', {universites: this.universites, filtres: template});
         },
         generateExcel(){
            this.$store.dispatch('generateExcel', {universites: this.universites});
         },        
         generateCSV(){
            this.$store.dispatch('generateCSV', {universites: this.universites});
         },

         
     },
    mounted(){
        if(this.lang && this.lang == 'ar')
            this.lang_select = 1;

        let filtre = '';
        if(this.filter){
            this.modals.filtres = true;
        }
        if(this.gouvernorat || this.formation || this.mention || this.specialite || this.diplome || this.type || this.universite || this.etablissement){
            if(this.formation){
                filtre += 'formation='+this.formation+'&';
                this.filtres.formation = this.formation;
            }
                
            if(this.mention){
                filtre += 'mention='+this.mention+'&';   
                this.filtres.mention = this.mention;
            }
                 
            if(this.specialite){
                filtre += 'specialite='+this.specialite+'&';
                this.filtres.specialite = this.specialite;
            }
                
            if(this.diplome){
                filtre += 'diplome='+this.diplome+'&';
                this.filtres.diplome = this.diplome;
            }

            if(this.type){
                filtre += 'type='+this.type+'&';
                this.filtres.type = this.type;
            }
            if(this.universite){
                filtre += 'universite='+this.universite+'&';
                this.filtres.universite = this.universite;
                this.$store.dispatch("getEtablissements", "universite="+this.universite).then(response => {
                });
            }
            if(this.etablissement){
                filtre += 'etablissement='+this.etablissement+'&';
                this.filtres.etablissement = this.etablissement;
            }    
            if(this.gouvernorat){
                filtre += 'gouvernorat='+this.gouvernorat+'&';
                this.filtres.gouvernorat = this.gouvernorat;
            }        
        }

        this.$store.dispatch("getUniversites", filtre).then(response => {
                this.loading = false;
        });
    },
    computed:{

        etablissements(){
            return this.$store.getters.etablissements;
        },
        universites(){
            return this.$store.getters.universites;
        },
        all_universites(){
            return this.$store.getters.all_universites;
        },
        gouvernorats(){
            return this.$store.getters.gouvernorats;
        }, 
        domaines(){
            return this.$store.getters.domaines;
        },
        diplomes(){
            return this.$store.getters.diplomes;
        },
        specialites(){
            return this.$store.getters.specialites;
        },
        mentions(){
            return this.$store.getters.mentions;
        },
        formation(){
            if (this.$route.query.formation)
                 return this.$route.query.formation;
            return null;
        },
        mention(){
            if (this.$route.query.mention)
                 return this.$route.query.mention;
            return null;
        },
        specialite(){
            if (this.$route.query.specialite)
                 return this.$route.query.specialite;
            return null;
        },
        diplome(){
            if (this.$route.query.diplome)
                 return this.$route.query.diplome;
            return null;
        },
        universite(){
            if (this.$route.query.universite)
                 return this.$route.query.universite;
            return null;
        },
        etablissement(){
            if (this.$route.query.etablissement)
                 return this.$route.query.etablissement;
            return null;
        },
        type(){
            if (this.$route.query.type)
                 return this.$route.query.type;
            return null;
        },
        gouvernorat(){
            if (this.$route.query.gouvernorat)
                 return this.$route.query.gouvernorat;
            return null;
        },
        filter(){
            if (this.$route.query.filter)
                 return this.$route.query.filter;
            return null;
        },
        lang(){
            if (this.$route.query.lang)
                 return this.$route.query.lang;
            return null;
        }
    },


}
</script>
<style scoped>
.content{
    padding : 20px;
    padding-top: 120px;
    
}
@media screen and (min-width: 768px){
    .content{
        padding : 60px;
         padding-top: 120px;
    }
}

.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-color: none;
}

.table tr td{
    border-right: 0.0625rem solid rgb(227, 227, 227);
}
.table tr td:hover{
    background-color: #e3e3e3;
}
.titleTable{
     text-align: center;
    vertical-align: middle;
    background: #dfe6e9;
    padding: 0px;
    
}
.titleTable h4{
    padding-top: 20px;
}
.holderTable{
        border: 1px solid #bdbdbb;
        border-top: none;
}
.btn.dropdown-toggle {
    height: 40px;
}
.exportBtn{
    margin-top: unset; 
    float: right;
}
@media screen and (max-width: 768px) {
.exportBtn{
    float: left;
}
}
</style>