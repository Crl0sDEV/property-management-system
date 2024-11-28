function loadTenants() {}

      function openArchivedModal() {
        document.getElementById("archivedModal").style.display = "block";
      }

      function closeArchivedModal() {
        document.getElementById("archivedModal").style.display = "none";
      }

      function showDetails(/* parameters */) {
        document.getElementById("tenantModal").style.display = "block";
      }

      window.onclick = function (event) {
        const archivedModal = document.getElementById("archivedModal");
        const tenantModal = document.getElementById("tenantModal");

        if (event.target == archivedModal) {
          archivedModal.style.display = "none";
        }
        if (event.target == tenantModal) {
          tenantModal.style.display = "none";
        }
      };

      let selectedTenantId;

      function loadTenants() {
        fetch("php/tenant-info/tenant-info.php")
          .then((response) => response.json())
          .then((tenants) => {
            const currentTenantsTable = document
              .getElementById("currentTenants")
              .getElementsByTagName("tbody")[0];
            currentTenantsTable.innerHTML = "";

            tenants.currentTenants.forEach((tenant) => {
              const row = currentTenantsTable.insertRow();
              row.setAttribute("data-tenant-id", tenant.id);
              row.innerHTML = `
          <td>${tenant.name}</td>
          <td>${tenant.unit_color}</td>
          <td>${tenant.start_date}</td>
          <td>${tenant.end_date}</td>
          <td>
          <button class="edit-dates-btn" onclick="showEditDatesModal(${tenant.id}, '${tenant.start_date}', '${tenant.end_date}')">
    <i class="fas fa-edit"></i> Edit Date
  </button>
          <button class="view-details" onclick="showDetails('${tenant.date}', '${tenant.name}', '${tenant.birthday}', '${tenant.birthplace}', '${tenant.nationality}', '${tenant.civil_status}', '${tenant.previous_address}', '${tenant.province}', '${tenant.occupation}', '${tenant.address_of_workplace}', '${tenant.phone_number}', '${tenant.email_address}', '${tenant.emergency_contact_number}', '${tenant.spouse_name}', '${tenant.spouse_occupation}', '${tenant.spouse_workplace_address}', '${tenant.tenant_phone_number}', '${tenant.number_of_tenants}', '${tenant.unit_color}', '${tenant.id}', false)"><i class="fas fa-info-circle"></i> View Details</button>
            <button class="archive-btn" onclick="archiveTenant(${tenant.id})"><i class="fas fa-archive"></i></button>
            </td>
        `;
            });

            const archivedTenantsTable = document
              .getElementById("archivedTenants")
              .getElementsByTagName("tbody")[0];
            archivedTenantsTable.innerHTML = "";

            tenants.archivedTenants.forEach((tenant) => {
              const row = archivedTenantsTable.insertRow();
              row.innerHTML = `
          <td>${tenant.name}</td>
          <td>${tenant.unit_color}</td>
          <td>${tenant.start_date}</td>
          <td>${tenant.end_date}</td>
          <td><button class="view-details-btn" onclick="showDetails('${tenant.date}', '${tenant.name}', '${tenant.birthday}', '${tenant.birthplace}', '${tenant.nationality}', '${tenant.civil_status}', '${tenant.previous_address}', '${tenant.province}', '${tenant.occupation}', '${tenant.address_of_workplace}', '${tenant.phone_number}', '${tenant.email_address}', '${tenant.emergency_contact_number}', '${tenant.spouse_name}', '${tenant.spouse_occupation}', '${tenant.spouse_workplace_address}', '${tenant.tenant_phone_number}', '${tenant.number_of_tenants}', '${tenant.unit_color}', '${tenant.id}', true)"><i class="fas fa-info-circle"></i> Details</button>
            <button class="unarchive-btn" onclick="unarchiveTenant(${tenant.id})">
                <i class="fas fa-undo"></i></button>
            </td>
      `;
            });
          })
          .catch((error) => console.error("Error fetching tenants:", error));
      }

      function showDetails(
        date,
        name,
        birthday,
        birthplace,
        nationality,
        civilstatus,
        previousaddress,
        province,
        occupation,
        addressofworkplace,
        phonenumber,
        emailaddress,
        emergencycontactnumber,
        spousename,
        spouseoccupation,
        spouseworkplaceaddress,
        tenantphonenumber,
        numberoftenants,
        unitcolor,
        id,
        isArchived
      ) {
        document.getElementById("tenantDate").innerText = date;
        document.getElementById("tenantName").innerText = name;
        document.getElementById("tenantBirthday").innerText = birthday;
        document.getElementById("tenantBirthplace").innerText = birthplace;
        document.getElementById("tenantNationality").innerText = nationality;
        document.getElementById("tenantCivilstatus").innerText = civilstatus;
        document.getElementById("tenantPreviousaddress").innerText =
          previousaddress;
        document.getElementById("tenantProvince").innerText = province;
        document.getElementById("tenantOccupation").innerText = occupation;
        document.getElementById("tenantAddressofworkplace").innerText =
          addressofworkplace;
        document.getElementById("tenantPhonenumber").innerText = phonenumber;
        document.getElementById("tenantEmailaddress").innerText = emailaddress;
        document.getElementById("tenantEmergencycontactnumber").innerText =
          emergencycontactnumber;
        document.getElementById("tenantSpousename").innerText = spousename;
        document.getElementById("tenantSpouseoccupation").innerText =
          spouseoccupation;
        document.getElementById("tenantSpouseworkplaceaddress").innerText =
          spouseworkplaceaddress;
        document.getElementById("tenantTenantphonenumber").innerText =
          tenantphonenumber;
        document.getElementById("tenantNumberoftenants").innerText =
          numberoftenants;
        document.getElementById("tenantUnitcolor").innerText = unitcolor;
        selectedTenantId = id;
        document.getElementById("tenantModal").style.display = "block";

        const editButton = document.querySelector(".edit-btn");
        editButton.style.display = isArchived ? "none" : "block";
      }

      function closeModal() {
        document.getElementById("tenantModal").style.display = "none";
      }

      function showEdit(
        date,
        name,
        birthday,
        birthplace,
        nationality,
        civilstatus,
        previousaddress,
        province,
        occupation,
        addressofworkplace,
        phonenumber,
        emailaddress,
        emergencycontactnumber,
        spousename,
        spouseoccupation,
        spouseworkplaceaddress,
        tenantphonenumber,
        numberoftenants
      ) {
        document.getElementById("editDate").value = date;
        document.getElementById("editName").value = name;
        document.getElementById("editBirthday").value = birthday;
        document.getElementById("editBirthplace").value = birthplace;
        document.getElementById("editNationality").value = nationality;
        document.getElementById("editCivilstatus").value = civilstatus;
        document.getElementById("editPreviousaddress").value = previousaddress;
        document.getElementById("editProvince").value = province;
        document.getElementById("editOccupation").value = occupation;
        document.getElementById("editAddressofworkplace").value =
          addressofworkplace;
        document.getElementById("editPhonenumber").value = phonenumber;
        document.getElementById("editEmailaddress").value = emailaddress;
        document.getElementById("editEmergencycontactnumber").value =
          emergencycontactnumber;
        document.getElementById("editSpousename").value = spousename;
        document.getElementById("editSpouseoccupation").value =
          spouseoccupation;
        document.getElementById("editSpouseworkplaceaddress").value =
          spouseworkplaceaddress;
        document.getElementById("editTenantphonenumber").value =
          tenantphonenumber;
        document.getElementById("editNumberoftenants").value = numberoftenants;
        document.getElementById("editModal").style.display = "block";
      }

      function closeEditModal() {
        document.getElementById("editModal").style.display = "none";
      }

      function updateTenant(event) {
        event.preventDefault();

        const data = {
          id: selectedTenantId,
          date: document.getElementById("editDate").value,
          name: document.getElementById("editName").value,
          birthday: document.getElementById("editBirthday").value,
          birthplace: document.getElementById("editBirthplace").value,
          nationality: document.getElementById("editNationality").value,
          civil_status: document.getElementById("editCivilstatus").value,
          previous_address: document.getElementById("editPreviousaddress")
            .value,
          province: document.getElementById("editProvince").value,
          occupation: document.getElementById("editOccupation").value,
          address_of_workplace: document.getElementById(
            "editAddressofworkplace"
          ).value,
          phone_number: document.getElementById("editPhonenumber").value,
          email_address: document.getElementById("editEmailaddress").value,
          emergency_contact_number: document.getElementById(
            "editEmergencycontactnumber"
          ).value,
          spouse_name: document.getElementById("editSpousename").value,
          spouse_occupation: document.getElementById("editSpouseoccupation")
            .value,
          spouse_workplace_address: document.getElementById(
            "editSpouseworkplaceaddress"
          ).value,
          tenant_phone_number: document.getElementById("editTenantphonenumber")
            .value,
          number_of_tenants: document.getElementById("editNumberoftenants")
            .value,
        };

        fetch("php/tenant-info/update-tenant.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((response) => response.json())
          .then((responseData) => {
            if (responseData.success) {
              alert("Tenant information updated successfully!");
              loadTenants();
            } else {
              console.error("Error updating tenant:", responseData.error);
            }
          })
          .catch((error) => console.error("Error updating tenant:", error));

        closeEditModal();
      }

      function archiveTenant(id) {
        fetch(`php/tenant-info/archiveTenant.php?archive_id=${id}`, {
          method: "GET",
        })
          .then((response) => response.json())
          .then((result) => {
            if (result.success) {
              loadTenants();
            }
          })
          .catch((error) => console.error("Error archiving tenant:", error));
      }

      function unarchiveTenant(tenantId) {
        fetch("php/tenant-info/tenant-info.php?unarchive_id=" + tenantId, {
          method: "POST",
        })
          .then((response) => response.json())
          .then((result) => {
            if (result.success) {
              
              loadTenants();
              alert("Tenant has been successfully unarchived.");
            } else {
              alert("Failed to unarchive tenant.");
            }
          })
          .catch((error) => console.error("Error unarchiving tenant:", error));
      }

      function showEditDatesModal(id, startDate, endDate) {
        selectedTenantId = id; 
        document.getElementById("editStartDate").value = startDate;
        document.getElementById("editEndDate").value = endDate;
        document.getElementById("editDatesModal").style.display = "block";
      }

      function closeEditDatesModal() {
        document.getElementById("editDatesModal").style.display = "none";
      }

      function updateDates(event) {
        event.preventDefault();
        const startDate = document.getElementById("editStartDate").value;
        const endDate = document.getElementById("editEndDate").value;

        
        fetch("php/tenant-info/update-dates.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            id: selectedTenantId,
            start_date: startDate,
            end_date: endDate,
          }),
        })
          .then((response) => response.json())
          .then((result) => {
            if (result.success) {
              alert("Dates updated successfully!");
              loadTenants(); 
            } else {
              alert("Failed to update dates.");
            }
            closeEditDatesModal();
          })
          .catch((error) => {
            console.error("Error updating dates:", error);
          });
      }

      document.getElementById("logoutBtn").onclick = function () {
        window.location.href = "login.html";
      };

      window.onload = function () {
        loadTenants();
      };