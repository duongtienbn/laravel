<style>
    * {
    margin: 0;
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}

.content {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #c6dce4;
    z-index: 1000;
    border: 1px solid #0f0f0f;
    border-radius: 5px;
}

.button-header {
    width: 109px;
    height: 37px;
    font-size: 16px;
    font-weight: bold;
    color: hsl(0, 4%, 5%);
    text-align: center;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 15px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.submit {
    background-color: #10c1f7;
    color: #fff;
    border: none;
    padding: 6px 20px;
    width: 109px;
    height: 37px;
    border-radius: 15px;
    font-size: 16px;
    cursor: pointer;
}

.button {
    border: 1.2px solid rgba(0, 0, 0, 0.4);
    padding: 2px 7px;
    margin: 2.5px;
    background-color: rgba(0, 0, 0, 0.075);
    position: relative;
    margin-top: auto;
    border-radius: 3px;
}

.button::before {
    content: attr(data-tooltip);
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s;
}

.button:hover::before {
    opacity: 1;
}

.button:hover {
    color: #ebf1f3;
    background-color: #4e8eb8;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    border-radius: 5px;
    width: 40px;
    height: 40px;
}

.btn {
    --bs-btn-padding-x: 0.4rem;
    --bs-btn-padding-y: 0.2rem;
    --bs-btn-color: #000;
}


/*携帯電話は自動的に下にスクロールします */

@media (max-width: 767px) {
    .button-header {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        z-index: 999;
    }
    .submit {
        display: flex;
        position: fixed;
        bottom: 0;
        right: 0;
        width: 50%;
        justify-content: center;
        align-items: center;
        padding: 15px;
        z-index: 999;
    }
}
</style>
