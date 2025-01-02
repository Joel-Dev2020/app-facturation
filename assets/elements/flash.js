import Swal from 'sweetalert2'

export default class Flash extends HTMLElement {
    async connectedCallback() {
        const icon = this.getAttribute('type')
        const title = this.getAttribute('message')
        await Swal.fire({
            toast: true,
            position: "top-end",
            icon,
            title,
            howCloseButton: true,
            timerProgressBar: true,
            showConfirmButton: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            timer: 3000
        });
    }
}