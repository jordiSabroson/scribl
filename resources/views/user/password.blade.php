<div class="mt-5 mx-3">
    <div class="d-flex border-bottom justify-content-start mb-2">
        <h2>Cambiar contraseña</h2>
    </div>
    <div class="container-fluid">

        <div class="d-flex flex-column justify-content-center align-items-center mt-5 h-100">
            <div class="w-25">
                <label for="old_password" class="form-label fw-bold fs-5 mb-3">Contraseña anterior*</label>
                <input type="password" class="form-control form-control-lg"
                    style="background-color: #eeeae5" id="old_password" required />

                <label for="new_password" class="form-label fw-bold fs-5 my-3">Nueva contraseña*</label>
                <input type="password" class="form-control form-control-lg"
                    style="background-color: #eeeae5" id="new_password" required />

                <label for="new_password_confirmation" class="form-label fw-bold fs-5 my-3">Repetir contraseña*</label>
                <input type="password" class="form-control form-control-lg mb-5"
                    style="background-color: #eeeae5" id="new_password_confirmation" required />
            </div>
            <div>
                <button class="bi bi-check2 btn btn-dark btn-md px-3 p-2 rounded-3 justify-content-bottom mt-5"
                    type="submit" onclick="editPassword({{ $user->id }})">&nbsp;Guardar cambios</button>
            </div>
        </div>
    </div>

</div>
