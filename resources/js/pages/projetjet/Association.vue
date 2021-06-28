<template>
<div class="content">
  <card>
    <template slot="header">
      <h5 class="title">Consulter les associations</h5>
      <div class="row filtre">
        <div class="col-sm-4">
          <base-input  label="Filtrer par gouvernorat">
            <select class="form-control " @change="onFiltreGouvernoratChange($event)"
            >
                <option v-for="(gouvernorat, index) in gouvernorats"
                        :value="gouvernorat.fr" 
                        :key="index"
                        >{{gouvernorat.fr}}</option>
            </select>
          </base-input>
        </div>
         <div class="col-sm-2">
              <base-button style="    margin-top: 23px;" type="warning" fill v-on:click="onFiltreAll()">Voir tous</base-button>
        </div>
         <div class="col-sm-6">
              <base-button  v-if="parseInt(user.role) == 3" class="addBtnClass" style="   margin-top: 23px;" type="success" fill v-on:click="actionNewAssociation()">Ajouter une nouvelle association</base-button>
        </div>
      </div>
    </template>
        <div class="table-responsive">
        <table class="table tablesorter text-left">
            <thead class="text-primary">
            <tr>
                <slot nom="columns">
                <th>Nom</th>
                <th>telephone</th>
                <th>adresse</th>
                <th>gouvernorat</th>
                <th>&nbsp;</th>
                </slot>
            </tr>
            </thead>
            <tbody >
              <tr v-if="loading">
                <td colspan="7" >
                  <div class="login text-center"><i class="tim-icons  icon-refresh-02 rotating"></i></div>
                </td>
              </tr>
            <tr v-for="(association, index) in filtredAssociations"
                        :key="index"
                        >
                <td>{{association.nom}}</td>
                <td>{{association.telephone}}</td>
                
                <td>{{association.adresse.adresse}}</td>
                <td>{{association.adresse.gouvernorat}}</td>

                <td class="td-actions text-right" v-if="parseInt(user.role) == 3">
                    <base-button type="success" size="sm" icon v-on:click="selectAssociation(association)">
                     <i class="tim-icons icon-settings"></i>
                    </base-button>
                    <base-button type="danger" size="sm" icon v-on:click="selectedAssociation = association.id; modals.deleteAssociation = true;">
                      <i class="tim-icons icon-simple-remove"></i>
                </base-button>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    <template slot="footer">
      <!-- <base-button type="success" fill v-on:click="saveDon()">Entregistrer</base-button> -->
    </template>
  </card>

  	<modal :show.sync="modals.deleteAssociation">
		<template slot="header">
			Supprimer 
		</template>

        Etes-vous sûr de supprimer cette association ?

  
		<template slot="footer">
			<base-button type="secondary" @click="modals.deleteAssociation = false;"
				>Annuler</base-button
			>
			<base-button type="danger" @click="deleteAssociation()"
				>Supprimer</base-button
			>
		</template>
	</modal>
	<modal :show.sync="modals.newAssociation"  class="text-left">
		<template slot="header">
			Ajouter une nouvelle association
		</template>

        <template>
            <base-input label="Nom : "
                  v-model="newAssociation.nom"
                  type="text"
                  placeholder="Nom :">
             </base-input>
            <base-input label="Telephone :"
                  v-model="newAssociation.telephone"
                  type="number"
                  placeholder="Télephone">
             </base-input>

            <base-input label="Gouvernorat">
                <select class="form-control" v-model="newAssociation.adresse.gouvernorat">
                    <option v-for="(gouvernorat, index) in gouvernorats"
                                :value="gouvernorat.fr" 
                                :key="index"
                                >{{gouvernorat.fr}}</option>
                </select>
            </base-input> 
              <base-input label="Adresse : "
                  v-model="newAssociation.adresse.adresse"
                  type="text"
                  placeholder="Adresse">
             </base-input>
        
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.newAssociation = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="actionAssociation()"
				>{{this.action == 'create'? 'Ajouter' : 'Update'}}</base-button
			>
     
		</template>
  
	</modal>
 </div>
 
</template>
<script>
import { Card, BaseInput } from "../../components/index";

import BaseButton from "../../components/BaseButton";
import BaseTable from "../../components/BaseTable";
import { Modal } from "../../components/index";
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
				donModal: false,
				acteurModal: false,
				newAssociation: false,
				deleteAssociation: false
			},
			loading: true,
			selectedDon: {
				adresse: {}
			},
			selectedActeur: {
				adresse: {}
			},
			newAssociation: {
				adresse: {}
			},
			action: "create",
			selectedAssociation: 0
		};
	},
	methods: {
		onEtatChange(event, donId) {
			this.$store
				.dispatch("updateEtatDon", {
					donId: donId,
					etat: event.target.value
				})
				.then(response => {
					//console.log(response);
					//Notifier
				});
		},
		actionAssociation() {
			// let adresse = this.newAssociation.adresse;
			// delete this.newAssociation.adresse;
			// this.newAssociation["adresse"] = adresse.adresse;
			// this.newAssociation["gouvernorat"] = adresse.gouvernorat;
			if (this.verifierFormulaire()) {
				if (this.action == "create") {
					this.$store
						.dispatch("newAssociation", this.newAssociation)
						.then(response => {
							//console.log(response);
							this.$notify({
								icon: "tim-icons icon-bell-55",
								horizontalAlign: "right",
								verticalAlign: "top",
								type: "success",
								timeout: 4000,
								message: "Nouvelle association créee!"
							});
							this.modals.newAssociation = false;
						});
				} else if (this.action == "update") {
					this.$store
						.dispatch("updateAssociation", {
							associationId: this.newAssociation.id,
							association: this.newAssociation
						})
						.then(response => {
							//console.log(response);
							this.$notify({
								icon: "tim-icons icon-bell-55",
								horizontalAlign: "right",
								verticalAlign: "top",
								type: "primary",
								timeout: 4000,
								message: "association modifiée!"
							});
							this.modals.newAssociation = false;
							// delete this.newAssociation.adresse;
							// this.newAssociation["adresse"] = adresse;
						});
        }
      }
		},
		verifierFormulaire() {
			if (
				this.newAssociation.telephone == "" ||
				this.newAssociation.nom == "" ||
			  this.newAssociation.adresse.adresse == "" 
			) {
				this.$notify({
					type: "danger",
					timeout: 4000,
					message: "Veuillez remplir tous les champs!",
					icon: "tim-icons icon-bell-55",
					horizontalAlign: "right",
					verticalAlign: "top"
				});
				return false;
			}
			if (!this.checkPhone(this.newAssociation.telephone)) {
				return false;
			}
			return true;
		},
		checkPhone(phone) {
			var strPhone = phone + "";
			//console.log(strPhone.length);
			//console.log(parseInt(strPhone[0]));
			if (
				strPhone.length == 8 &&
				(parseInt(strPhone[0]) == 2 ||
					parseInt(strPhone[0]) == 4 ||
					parseInt(strPhone[0]) == 5 ||
					parseInt(strPhone[0]) == 9 ||
					parseInt(strPhone[0]) == 7)
			) {
				return true;
			} else {
				this.$notify({
					type: "danger",
					timeout: 4000,
					message: "Numéro de téléphone invalide!",
					icon: "tim-icons icon-bell-55",
					horizontalAlign: "right",
					verticalAlign: "top"
				});
				return false;
			}
		},
		deleteAssociation() {
			this.$store
				.dispatch("deleteAssociation", this.selectedAssociation)
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "danger",
						timeout: 4000,
						message: "association supprimée!"
					});
					this.modals.deleteAssociation = false;
				});
		},

		selectDon(association) {
			this.selectedDon = association;
			this.modals.donModal = true;
		},
		selectAssociation(acteur) {
			this.action = "update";
			this.newAssociation = acteur;
			//console.log(this.newAssociation);
			this.modals.newAssociation = true;
		},
		actionNewAssociation() {
			this.action = "create";
			this.newAssociation = {
				nom: "",
				telephone: "",
				adresse: {adresse: '', gouvernorat: "Ariana" }
			};
			this.modals.newAssociation = true;
		},

		onFiltreGouvernoratChange(event) {
			this.filtredAssociations = this.associations.filter(function(el) {
				return el.adresse.gouvernorat == event.target.value;
			});
		},
		onEtatChange(event) {
			this.filtredAssociations = this.associations.filter(function(el) {
				return el.role == event.target.value;
			});
		},
		onFiltreAll() {
			this.filtredAssociations = this.associations;
		}
	},
	mounted() {
		this.$store.dispatch("getAssociations").then(response => {
			this.loading = false;
		});
	},
	computed: {
		user() {
			return this.$store.getters.user;
		},
		associations: {
			get() {
				return this.$store.getters.associations;
			}
		},
		filtredAssociations: {
			get() {
				return this.$store.getters.filtredAssociations;
			},
			set(value) {
				this.$store.commit("setFiltredAssociations", JSON.stringify(value));
			}
		},
		gouvernorats() {
			return this.$store.getters.gouvernorats;
		}
	}
};
</script>
<style scoped>
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
.input-group-append,
.input-group-prepend .input-group-text,
.input-group-prepend .input-group-text {
	border-color: rgba(29, 37, 59, 0.5) !important;
}
</style>
