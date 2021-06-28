<template>
    <div class="content">
        <card
            type="secondary"
            header-classes="bg-white pb-5"
            body-classes="px-lg-5 py-lg-5"
            class="border-0 mb-0"
        >
            <template>
                <div class="text-muted text-center mb-3">
                    <small>Sign in with</small>
                </div>
                <div class="btn-wrapper text-center">
                    <base-button type="default">
                        <img
                            slot="icon"
                            src="https://demos.creative-tim.com/argon-design-system/assets/img/icons/common/github.svg"
                        />
                        Github
                    </base-button>

                    <base-button type="danger">
                        <img
                            slot="icon"
                            src="https://demos.creative-tim.com/argon-design-system/assets/img/icons/common/google.svg"
                        />
                        Google
                    </base-button>
                </div>
            </template>
            <template>
                <div class="text-center text-muted mb-4">
                    <small>Register</small>
                </div>
                <form action="#" role="form" @submit.prevent="register">
                    <base-input
                        alternative
                        class="mb-3"
                        placeholder="Nom"
                        addon-left-icon="tim-icons icon-single-02"
                        v-model="name"
                        type="text"
                    >
                    </base-input>
                    <base-input
                        alternative
                        class="mb-3"
                        placeholder="Email"
                        addon-left-icon="tim-icons icon-single-02"
                        v-model="email"
                        type="email"
                    >
                    </base-input>
                    <base-input
                        alternative
                        type="password"
                        placeholder="Password"
                        addon-left-icon="tim-icons icon-lock-circle"
                        v-model="password"
                    >
                    </base-input>

                    <div class="text-center">
                        <base-button nativeType="submit" class="my-4"
                            >Créer un compte</base-button
                        >
                    </div>
                </form>
            </template>
        </card>
    </div>
</template>
<script>
import { Modal, BaseInput, Card } from "../components/index";

export default {
    name: "login",
    components: {
        Modal,
        BaseInput,
        Card
    },
    data() {
        return {
            name: "",
            email: "",
            password: ""
        };
    },
    methods: {
        register() {
            this.$store
                .dispatch("register", {
                    name: this.name,
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    this.$router.push("/login");
                });
        }
    }
};
</script>
<style scoped>
.content {
    padding: 185px;
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
