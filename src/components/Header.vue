<template>
    <div class="uk-section">
        <div class="uk-container uk-align-center">
            <nav class="uk-navbar-container" uk-navbar>
                <div class="uk-navbar-left">
                    <img src="../../public/logo.svg" />
                    <ul id="navbar" class="uk-navbar-nav uk-visible@s">
                        <li class="uk-active">
                            <a id="styling-menu" href="#">Home</a>
                        </li>
                        <li class="uk-active">
                            <a id="styling-menu" href="#">Dashboard</a>
                        </li>
                    </ul>
                    <div class="uk-navbar-item">
                        <form class="uk-search uk-search-small">
                            <span uk-search-icon></span>
                            <input
                                class="uk-search-input"
                                type="search"
                                placeholder="Search"
                                aria-label="Search"
                            />
                        </form>
                    </div>
                    <div class="uk-navbar-item">
                        <button class="uk-button uk-button-text">Login</button>
                        <button class="uk-button uk-button-text">Signup</button>
                    </div>
                    <a
                        href="#"
                        class="uk-navbar-toggle uk-hidden@s"
                        uk-navbar-toggle-icon
                        uk-toggle="target: #sidenav"
                    ></a>
                </div>

                <button
                    class="uk-button uk-button-default uk-margin-small-right"
                    type="button"
                    uk-toggle="target: #offcanvas-nav-primary"
                >
                    Primary Nav
                </button>

                <button
                    class="uk-button uk-button-default"
                    type="button"
                    uk-toggle="target: #offcanvas-nav"
                >
                    Default Nav
                </button>

                <div id="offcanvas-nav-primary" uk-offcanvas="overlay: true">
                    <div class="uk-offcanvas-bar uk-flex uk-flex-column">
                        <ul
                            class="uk-nav uk-nav-primary uk-nav-center uk-margin-auto-vertical"
                        >
                            <li class="uk-active"><a href="#">Active</a></li>
                            <li class="uk-parent">
                                <a href="#">Parent</a>
                                <ul class="uk-nav-sub">
                                    <li><a href="#">Sub item</a></li>
                                    <li><a href="#">Sub item</a></li>
                                </ul>
                            </li>
                            <li class="uk-nav-header">Header</li>
                            <li>
                                <a href="#"
                                    ><span
                                        class="uk-margin-small-right"
                                        uk-icon="icon: table"
                                    ></span>
                                    Item</a
                                >
                            </li>
                            <li>
                                <a href="#"
                                    ><span
                                        class="uk-margin-small-right"
                                        uk-icon="icon: thumbnails"
                                    ></span>
                                    Item</a
                                >
                            </li>
                            <li class="uk-nav-divider"></li>
                            <li>
                                <a href="#"
                                    ><span
                                        class="uk-margin-small-right"
                                        uk-icon="icon: trash"
                                    ></span>
                                    Item</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">lol</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div
                    class="collapse navbar-collapse"
                    id="navbarSupportedContent"
                >
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                aria-current="page"
                                href="#"
                                >Home</a
                            >
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="navbarDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Dropdown
                            </a>
                            <ul
                                class="dropdown-menu"
                                aria-labelledby="navbarDropdown"
                            >
                                <li>
                                    <a class="dropdown-item" href="#">Action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >Another action</a
                                    >
                                </li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        >Something else here</a
                                    >
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Disabled</a>
                        </li>
                        <li class="nav-item">
                            <div class="position-relative">
                                <div
                                    class="rounded-circle ms-user-info bg-primary mx-3 d-flex justify-content-center align-items-center user-select-none"
                                    @click="
                                        settingsDropdownFlag =
                                            !settingsDropdownFlag
                                    "
                                >
                                    {{ $store.state.user.data.name }}
                                </div>
                                <div v-if="settingsDropdownFlag">
                                    <ul
                                        class="dropdown-menu d-block position-absolute end-0"
                                        v-if="$store.state.user.token"
                                    >
                                        <li class="p-2">
                                            <a href="" @click="logout"
                                                >Logout</a
                                            >
                                        </li>
                                        <li class="p-2">
                                            <router-link
                                                @click="
                                                    settingsDropdownFlag = false
                                                "
                                                :to="{ name: 'Dashboard' }"
                                                >Dashboard</router-link
                                            >
                                        </li>
                                    </ul>
                                    <ul v-else>
                                        <li class="p-2">
                                            <router-link :to="{ name: 'Login' }"
                                                >Login</router-link
                                            >
                                        </li>
                                        <li class="p-2">
                                            <router-link
                                                :to="{ name: 'Register' }"
                                                >Register</router-link
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div> -->
</template>

<script>
import store from "../store/index.js";
import { useRouter } from "vue-router";

export default {
    name: "Header",
    data() {
        return {
            settingsDropdownFlag: false,
            router: useRouter(),
        };
    },
    methods: {
        logout() {
            store.dispatch("logout").then((resp) => {
                this.router.push({
                    name: "Login",
                });
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.ms-user-info {
    overflow: hidden;
    width: 50px;
    height: 50px;
    cursor: pointer;
}

.uk-navbar-left > img {
    height: 100px;
    width: 320px;
}
</style>
