<template>
    <b-row>
        <b-col>
            <table>
                <tr>
                    <th colspan="8">{{ title }}</th>
                </tr>
                <tr>
                    <td class="bg-grey">
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td>n/a</td>
                    <td class="bg-grey">n/a</td>
                    <td>n/a</td>
                </tr>
                <tr>
                    <td class="bg-grey">
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td>
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td class="bg-grey">
                        <b-form-select :options="options"></b-form-select>
                    </td>
                    <td>n/a</td>
                    <td class="bg-grey">n/a</td>
                    <td>n/a</td>
                </tr>
                <tr>
                    <td class="bg-grey"><input type="text"></td>
                    <td><input type="text"></td>
                    <td class="bg-grey"><input type="text"></td>
                    <td><input type="text"></td>
                    <td class="bg-grey"><input type="text"></td>
                    <td><input type="text"></td>
                    <td class="bg-grey"><input type="text"></td>
                    <td><input type="text"></td>
                </tr>
            </table>
        </b-col>
    </b-row>
</template>

<script type="text/babel">
    export default {
        props: ['title'],
        data() {
            return {
                options: [
                    {value: null, text: 'Flooring'},
                    {value: null, text: 'E Wall Up'},
                    {value: null, text: 'S Wall up'}
                ]
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 3px;
    }

    table {
        width: 100%;
        td {
            width: 12.5%;
        }
        input {
            text-align: center;
            width: 100%;
            background-color: transparent;
            border: none;
        }
    }

    .bg-grey {
        background-color: #c3c3c3;
    }

    .custom-select {
        background-color: transparent;
        border: none;
        padding: 0;
    }

    select.form-control:not([size]):not([multiple]) {
        height: 24px;
        padding-left: 2em;
    }
</style>