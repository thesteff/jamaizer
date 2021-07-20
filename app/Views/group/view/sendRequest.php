<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Envoyer une demande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="send_group_request" method="post">
                    <div class="mb-3">
                        <textarea name="message" class="form-control" id="exampleFormControlTextarea1"
                            rows="3"></textarea>
                    </div>
                    <button class="btn btn-outline-dark mt-3 ms-2" data-bs-dismiss="modal"
                        type="submit">Envoyer</button>
                    <button type="button" class="btn btn-outline-dark mt-3 ms-2"
                        data-bs-dismiss="modal">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>