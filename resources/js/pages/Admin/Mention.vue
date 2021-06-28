<template>
	<div class="content">
		<card>
			<template slot="header">
				<h5 class="title">Gérer les mentions</h5>
				<div class="row filtre">
					<!-- <div class="col-xl-4">
						<base-input label="Filtrer par gouvernorat">
							<select
								class="form-control "
								@change="onFiltreGouvernoratChange($event)"
                                v-model="filtres.gouvernorat"
							>
                                <option value="" disabled selected>Rechercher par gouvernorat</option>
								<option
									v-for="(gouvernorat, index) in gouvernorats"
									:value="gouvernorat.fr"
									:key="index"
									>{{ gouvernorat.fr }}</option
								>
							</select>
						</base-input>
					</div>
					<div class="col-xl-2">
						<base-button
							style="    margin-top: 23px;"
							type="warning"
							fill
							v-on:click="onFiltreAll()"
							>Voir tous</base-button
						>
					</div> -->
					<div
						class="col-xl-3"
						v-if="parseInt(user.role) == 3"
					>
						<base-button
							style="   margin-top: 23px;"
							type="success"
							fill
							v-on:click="initMentionModal()"
							>Ajouter une nouvelle mention</base-button
						>
					</div>
				</div>
			</template>
			<div class="table-responsive">
				<table class="table tablesorter text-left">
					<thead class="text-primary">
						<tr>
							<slot nom="columns">
								<th>Titre (fr) </th>
								<th>Titre (ar)</th>
								<th>Domaine</th>
                                <th>Etablissements qui couvre ce mention</th>
								<th>&nbsp;</th>
							</slot>
						</tr>
					</thead>
					<tbody>
						<tr v-if="loading">
							<td colspan="7">
								<div class="login text-center">
									<i class="tim-icons  icon-refresh-02 rotating"></i>
								</div>
							</td>
						</tr>
						<tr v-if="mentions.length == 0">
							<td colspan="7">
								<div class="login text-center">
									Aucune donnée trouvée...
								</div>
							</td>
						</tr>
						<tr v-for="(mention, index) in mentions" :key="index">
							<td>{{ mention.titre }}</td>
							<td>{{ mention.titre_ar }}</td>
							<td>{{ mention.domaine ? mention.domaine.titre : '' }}</td>
							<td>
								<base-button
									simple
									type="primary"
									v-on:click="selectMention(mention)"
									>Etablissements</base-button
								>
							</td>

							<td
								class="td-actions text-right"
								v-if="parseInt(user.role) == 3"
							>
								<base-button
									type="success"
									size="sm"
									icon
									v-on:click="editMentionModal(mention)"
								>
									<i class="tim-icons icon-settings"></i>
								</base-button>
								<base-button
									type="danger"
									size="sm"
									icon
									v-on:click="deleteMention(mention.id)"
								>
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
        <modal :show.sync="modals.detailsModal">
            <template slot="header">
                Demandé par
            </template>
            <template>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Prentation:</span>
                    {{this.selectedMention.presentation}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Telephone:</span>
                    {{this.selectedMention.telephone}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Fax:</span>
                    {{this.selectedMention.fax}}&nbsp;
                </p>
                </div>
                <div class="typography-line text-left">
                <p>
                    <span style="bottom: unset; line-height: unset;">Lien:</span>
                    {{this.selectedMention.url}}&nbsp;
                </p>
                </div> 

            </template>
            <template slot="footer">
                <base-button type="secondary" @click="modals.detailsModal = false;"
                    >Fermer</base-button
                >
            </template>
        </modal>
		<modal :show.sync="modals.mention" class="text-left">
			<template slot="header">
				{{action == 'create' ? 'Ajouter' : 'Modifier' }}
			</template>

			<template>
				<base-input
					label="Titre : "
					v-model="mentionModel.titre"
					type="text"
					placeholder="titre :"
				>
				</base-input>
				<base-input
					label="Titre arabe: "
					v-model="mentionModel.titre_ar"
					type="text"
					placeholder="اسم الشعبة"
				>
				</base-input>
                <base-input label="Domaines">
                    <select
                        class="form-control "
                        v-model="mentionModel.domaine_id"
                    >
                        <option
                            v-for="(domaine, index) in domaines"
                            :value="domaine.id"
                            :key="index"
                            >{{ domaine.titre }}</option
                        >
                    </select>
                </base-input>
			</template>
			<template slot="footer">
				<base-button type="secondary" @click="modals.mention = false"
					>Annuler</base-button
				>
				<base-button type="primary" @click="actionMention">{{action == 'create' ? 'Ajouter' : 'Modifier' }}</base-button>
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
				detailsModal: false,
				mention: false,
				deleteMention: false
			},
			loading: true,
			mentionModel: {},
			action: "create",
            selectedMention: {},
            filtres: {
                gouvernorat: ''
            }
		};
	},
	methods: {
        selectMention(mention){
            this.selectedMention = mention;
            this.modals.detailsModal = true;
        },
        initMentionModal(){
            this.action = 'create';
            this.mentionModel = {};
            this.modals.mention = true;
        },
        editMentionModal(mention){
            this.action = 'update';
            this.mentionModel = mention;
            this.modals.mention = true;
        },
		actionMention() {
            // validation

			if (this.action == "create") {
				this.$store
					.dispatch("createMention", {mention: this.mentionModel})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "success",
							timeout: 4000,
							message: "Nouvelle mention crée!"
						});
						this.modals.mention = false;
					});
			} else if (this.action == "update") {
				this.$store
					.dispatch("updateMention", {mention: this.mentionModel})
					.then(response => {
						//console.log(response);
						this.$notify({
							icon: "tim-icons icon-bell-55",
							horizontalAlign: "right",
							verticalAlign: "top",
							type: "primary",
							timeout: 4000,
							message: "Mention modifiée!"
						});
						this.modals.mention = false;
					});
			}
		},
		deleteMention(selectedMention) {
            this.$dialog
            .confirm('Etes-vous sûre de supprimer ce mention ?', {cancelText: 'Non', okText: 'Oui', customClass:'modal-danger'})
            .then((dialog) => {
			this.$store
				.dispatch("deleteMention", selectedMention)
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "danger",
						timeout: 4000,
						message: "Mention supprimée!"
					});
				});
            })
            .catch(() => {
            });
        },
        onFiltreGouvernoratChange(event){
            this.$store.dispatch("getMentions", 'gouvernorat='+event.target.value).then(response => {
                this.loading = false;
            });
        },
        onFiltreAll(){
            this.filtres.gouvernorat = '';
            this.$store.dispatch("getMentions", "").then(response => {
                this.loading = false;
            });
        }
	},
	created() {
		this.$store.dispatch("getMentions", "").then(response => {
			this.loading = false;
		});
	},
	computed: {
		user() {
			return this.$store.getters.user;
		},
		mentions() {
			return this.$store.getters.mentions;
		},
		domaines() {
			return this.$store.getters.domaines;
        },
		gouvernorats() {
			return this.$store.getters.gouvernorats;
		}
	}
};
</script>
