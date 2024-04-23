<template>
    <div v-if="!success" class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh;">
                    <div class="d-flex justify-content-center align-items-center" style="font-size: 32px; padding-bottom: 10px">Регистрация</div>
                    <form
                        style="width: 350px; border: 1px solid #1E1F22;"
                        class="d-flex flex-column p-3"
                        @submit.prevent="handleRegistration">
                        <div class="mb-3">
                            <label for="name" class="form-label">Введите ваше имя</label>
                            <input
                                type="text"
                                required
                                style="background-color: #1E1F22"
                                class="form-control"
                                id="name"
                                placeholder="Иван"
                                v-model="formData.name"
                                :class="{ 'is-invalid': errors.name }"
                            />
                            <div class="invalid-feedback" v-if="errors.name">Поле обязательно для заполнения</div>
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Введите вашу фамилию</label>
                            <input
                                type="text"
                                required
                                style="background-color: #1E1F22"
                                class="form-control"
                                id="surname"
                                placeholder="Иванов"
                                v-model="formData.surname"
                                :class="{ 'is-invalid': errors.surname }"
                            />
                            <div class="invalid-feedback" v-if="errors.surname">Поле обязательно для заполнения</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Электронная почта</label>
                            <input
                                type="email"
                                required
                                style="background-color: #1E1F22"
                                class="form-control"
                                id="email"
                                placeholder="example@mail.ru"
                                v-model="formData.email"
                                :class="{ 'is-invalid': errors.email }"
                            />
                            <div class="invalid-feedback" v-if="errors.email">Поле обязательно для заполнения</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input
                                type="password"
                                required
                                style="background-color: #1E1F22"
                                class="form-control"
                                id="password"
                                v-model="formData.password"
                                :class="{ 'is-invalid': errors.password }"
                            />
                            <div class="invalid-feedback" v-if="errors.password">Поле обязательно для заполнения</div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmed" class="form-label">Подтверждение пароля</label>
                            <input
                                type="password"
                                required
                                style="background-color: #1E1F22"
                                class="form-control"
                                id="password_confirmation"
                                v-model="formData.password_confirmation"
                                :class="{ 'is-invalid': errors.password_confirmation }"
                            />
                            <div class="invalid-feedback" v-if="errors.password_confirmation">Поле обязательно для заполнения</div>
                        </div>
                        <div v-if="error" class="mb-3">
                            <span style="color: #ff6633">{{ error }}</span>
                        </div>
                        <button type="submit" class="btn btn-primary align-self-center">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                    <div style="font-size: 20px">Успешная регистрация</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            formData: {
                name: '',
                surname: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            errors: {},
            error: '',
            success: false,
        };
    },
    methods: {
        async handleRegistration() {
            try {
                if (this.formData.password !== this.formData.password_confirmation) {
                    this.error = "Пароли не совпадают";
                    return;
                }
                await axios.post('http://127.0.0.1:8000/', this.formData);
                this.success = true;
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 401)
                        this.error = "Пользователь уже зарегистрирован";
                    if (error.response.status === 422)
                        this.error = "Неверный адрес электронной почты";
                } else {
                    this.error = 'Ошибка при отправке запроса';
                }
            }
        },
    },
};
</script>

<style>
body {
    background-color: #1E1F22;
    color: #fff;
}

.container {
    background-color: #2B2D30;
}

.form-control {
    background-color: #2B2D30;
    color: #fff;
    border-color: #777;
}

.form-control::placeholder {
    color: #ffffff;
    opacity: 45%;
}

.form-control[type="password"] {
    color: #ffffff;
}

.form-control[type="text"] {
    color: #ffffff;
}

.form-control[type="email"] {
    color: #ffffff;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}
.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.is-invalid {
    border-color: #dc3545;
}
.invalid-feedback {
    color: #dc3545;
}
</style>
