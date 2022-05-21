class functions {
  constructor(){
    this.encrypObj = new Encryption();
  }

  encrypt(value="", nonce=""){
    if( value != "" && nonce != "" ){
      return this.encrypObj.encrypt(value, nonce);
    } else {
      return null;
    }
  }

  decrypt(value="", nonce=""){
    if( value != "" && nonce != "" ){
      return this.encrypObj.decrypt(value, nonce);
    } else {
      return null;
    }
  }
}
