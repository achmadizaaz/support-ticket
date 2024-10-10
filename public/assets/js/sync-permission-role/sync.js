let allCheckbox = document.querySelectorAll(".checkbox").length,
    allCheckboxChecked = document.querySelectorAll(".checkbox:checked").length;
allCheckbox == allCheckboxChecked &&
    (document.getElementById("selectAll").checked = !0),
    $(document).ready(function () {
        // Checklist All
        $("#selectAll").click(function (e) {
            $(this)
                .closest("table")
                .find("td input:checkbox")
                .prop("checked", this.checked);
        }),
            $("table").on("change", "td input:checkbox", function () {
                let e;
                document.querySelectorAll(".checkbox").length ==
                document.querySelectorAll(".checkbox:checked").length
                    ? (document.getElementById("selectAll").checked = !0)
                    : (document.getElementById("selectAll").checked = !1);
            });
    });

// All checklist

// Checklist ticket
let ticketUnChecked = document.querySelectorAll(".ticket-group").length,
    ticketChecked = document.querySelectorAll(".ticket-group:checked").length;
function checkAllTicket(e) {
    document
        .querySelectorAll(".ticket-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllUser() {
    document.querySelector("input.checkAllTicket").checked =
        ticketUnChecked == ticketChecked;
}
$(".ticket-group").on("change", function () {
    let e;
    document.querySelectorAll(".ticket-group").length ==
    document.querySelectorAll(".ticket-group:checked").length
        ? (document.getElementById("all-ticket").checked = !0)
        : (document.getElementById("all-ticket").checked = !1);
}),
    ticketUnChecked == ticketChecked &&
        (document.getElementById("all-ticket").checked = !0);

// End Checklist Ticket

// Checklist category
let categoryUnChecked = document.querySelectorAll(".category-group").length,
    categoryChecked = document.querySelectorAll(
        ".category-group:checked"
    ).length;
function checkAllCategory(e) {
    document
        .querySelectorAll(".category-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllUser() {
    document.querySelector("input.checkAllCategory").checked =
        categoryUnChecked == categoryChecked;
}
$(".category-group").on("change", function () {
    let e;
    document.querySelectorAll(".category-group").length ==
    document.querySelectorAll(".category-group:checked").length
        ? (document.getElementById("all-category").checked = !0)
        : (document.getElementById("all-category").checked = !1);
}),
    categoryUnChecked == categoryChecked &&
        (document.getElementById("all-category").checked = !0);

// End Checklist Category

// Checklist unit
let unitUnChecked = document.querySelectorAll(".unit-group").length,
    unitChecked = document.querySelectorAll(".unit-group:checked").length;
function checkAllUnit(e) {
    document
        .querySelectorAll(".unit-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllUser() {
    document.querySelector("input.checkAllUnit").checked =
        unitUnChecked == unitChecked;
}
$(".unit-group").on("change", function () {
    let e;
    document.querySelectorAll(".unit-group").length ==
    document.querySelectorAll(".unit-group:checked").length
        ? (document.getElementById("all-unit").checked = !0)
        : (document.getElementById("all-unit").checked = !1);
}),
    unitUnChecked == unitChecked &&
        (document.getElementById("all-unit").checked = !0);

// End Checklist Unit

// Checklist NotifCategory
let notifCategoryUnChecked = document.querySelectorAll(
        ".notif-category-group"
    ).length,
    notifCategoryChecked = document.querySelectorAll(
        ".notif-category-group:checked"
    ).length;
function checkAllNotifCategory(e) {
    document
        .querySelectorAll(".notif-category-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllNotifCategory() {
    document.querySelector("input.checkAllNotifCategory").checked =
        notifCategoryUnChecked == notifCategoryChecked;
}
$(".notif-category-group").on("change", function () {
    let e;
    document.querySelectorAll(".notif-category-group").length ==
    document.querySelectorAll(".notif-category-group:checked").length
        ? (document.getElementById("all-notif-category").checked = !0)
        : (document.getElementById("all-notif-category").checked = !1);
}),
    notifCategoryUnChecked == notifCategoryChecked &&
        (document.getElementById("all-notif-category").checked = !0);

// End Checklist NotifCategory

// Checklist user
let userUnChecked = document.querySelectorAll(".user-group").length,
    userChecked = document.querySelectorAll(".user-group:checked").length;
function checkAllUser(e) {
    document
        .querySelectorAll(".user-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllUser() {
    document.querySelector("input.checkAllUser").checked =
        userUnChecked == userChecked;
}
$(".user-group").on("change", function () {
    let e;
    document.querySelectorAll(".user-group").length ==
    document.querySelectorAll(".user-group:checked").length
        ? (document.getElementById("all-user").checked = !0)
        : (document.getElementById("all-user").checked = !1);
}),
    userUnChecked == userChecked &&
        (document.getElementById("all-user").checked = !0);

// End Checklist User

// Checklist Role
let roleUnChecked = document.querySelectorAll(".role-group").length,
    roleChecked = document.querySelectorAll(".role-group:checked").length;
function checkAllRole(e) {
    document
        .querySelectorAll(".role-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllRole() {
    document.querySelector("input.checkAllRole").checked =
        roleUnChecked == roleChecked;
}
$(".role-group").on("change", function () {
    let e;
    document.querySelectorAll(".role-group").length ==
    document.querySelectorAll(".role-group:checked").length
        ? (document.getElementById("all-role").checked = !0)
        : (document.getElementById("all-role").checked = !1);
}),
    roleUnChecked == roleChecked &&
        (document.getElementById("all-role").checked = !0);

// End Checklist Role

// Checklist Report
let reportUnChecked = document.querySelectorAll(".report-group").length,
    reportChecked = document.querySelectorAll(".report-group:checked").length;
function checkAllReport(e) {
    document
        .querySelectorAll(".report-group")
        .forEach((n) => (n.checked = e.checked));
}
function setCheckAllReport() {
    document.querySelector("input.checkAllReport").checked =
        reportUnChecked == reportChecked;
}
$(".report-group").on("change", function () {
    let e;
    document.querySelectorAll(".report-group").length ==
    document.querySelectorAll(".report-group:checked").length
        ? (document.getElementById("all-report").checked = !0)
        : (document.getElementById("all-report").checked = !1);
}),
    reportUnChecked == reportChecked &&
        (document.getElementById("all-report").checked = !0);

// End Checklist Report

// Tambahkan log untuk memastikan script ter-load
// console.log("Script loaded successfully");
