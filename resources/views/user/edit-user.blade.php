<div class="mt-5 mx-3">
    <div class="d-flex border-bottom justify-content-start mb-2">
        <h2>Editar perfil</h2>
    </div>
    <div class="container-fluid">

        <div class="d-flex flex-column justify-content-center align-items-center mt-5 h-100">
            <div class="w-25">
                <label for="email" class="form-label fw-bold fs-5 mb-3" >Email*</label>
                <input type="email" id="email" class="form-control form-control-lg" style="background-color: #eeeae5"
                    value="{{ $user->email }}" required />

                <label for="name" class="form-label fw-bold fs-5 my-3" >Nombre*</label>
                <input type="text" id="name" class="form-control form-control-lg" style="background-color: #eeeae5"
                    value="{{ $user->name }}" required />

                <label for="name" class="form-label fw-bold fs-5 my-3" >Apellidos</label>
                <input type="text" id="surname" class="form-control form-control-lg mb-5" style="background-color: #eeeae5"
                    value="{{ $user->surname }}" />
            </div>
            <div>
                <button class="bi bi-check2 btn btn-dark btn-md px-3 p-2 rounded-3 justify-content-bottom mt-5"
                    type="submit" onclick="editProfile({{ $user->id }})">&nbsp;Guardar cambios</button>
            </div>
        </div>
    </div>

</div>
