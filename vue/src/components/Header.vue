<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
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
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    </ul>
                    <form class="d-flex">
                        <input
                            class="form-control me-2"
                            type="search"
                            placeholder="Search"
                            aria-label="Search"
                        />
                        <button class="btn btn-outline-success" type="submit">
                            Search
                        </button>
                    </form>
                    <div class="position-relative">
                        <div
                            class="rounded-circle ms-user-info bg-primary mx-3 d-flex justify-content-center align-items-center user-select-none"
                            @click="
                                settingsDropdownFlag = !settingsDropdownFlag
                            "
                        >
                            {{ $store.state.user.data.name }}
                        </div>
                        <ul
                            class="dropdown-menu d-block position-absolute end-0"
                            v-if="settingsDropdownFlag"
                        >
                            <li class="p-2">
                                <a href="" @click="logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
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
    width: 50px;
    height: 50px;
    cursor: pointer;
}
</style>
