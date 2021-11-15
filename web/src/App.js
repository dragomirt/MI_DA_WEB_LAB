import React, { useCallback, useRef, useState } from 'react';
import {
  ChakraProvider,
  Box,
  Text,
  Link,
  VStack,
  Code,
  Grid,
  theme,
  Button,
  Container,
  Input,
} from '@chakra-ui/react';
import { ColorModeSwitcher } from './ColorModeSwitcher';
import { Logo } from './Logo';
import config from './config';
import { useDropzone } from 'react-dropzone';
import axios from 'axios';


function FileDrop() {
  const onDrop = useCallback(acceptedFiles => {
    let formData = new FormData();
    formData.append('file', acceptedFiles[0]);

    fetch(config.api_url + '/api/scan', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'multipart/form-data',
        'Authorization': 'Bearer ' + config.api_key,
      },
      mode: 'no-cors',
      body: formData,
    }).then((res) => {
      console.log(res);
    });
  }, []);
  const { getRootProps, getInputProps, isDragActive } = useDropzone({ onDrop });

  return (
    <div {...getRootProps()}>
      <input {...getInputProps()} />
      {
        isDragActive ?
          <p>Drop the files here ...</p> :
          <p>Drag 'n' drop some files here, or click to select files</p>
      }
    </div>
  );
}

const FileUploader = ({ onFileSelectError, onFileSelectSuccess }) => {
  const fileInput = useRef(null);

  const handleFileInput = (e) => {
    // handle validations

    const file = e.target.files[0];
    console.log(file.size);
    if (file.size > 3951030)
      onFileSelectError({ error: 'File size cannot exceed more than 1MB' });
    else onFileSelectSuccess(file);
  };

  return (
    <div className='file-uploader'>
      <input type='file' onChange={handleFileInput} />
      <button onClick={e => fileInput.current && fileInput.current.click()} className='btn btn-primary'>File</button>
    </div>
  );
};

function App() {
  const [selectedFile, setSelectedFile] = useState(null);

  const submitFileScan = () => {

    let formData = new FormData();
    formData.append('file', selectedFile);

    axios({
      url: config.api_url + '/api/scan',
      method: 'post',
      headers: {
        'Authorization': 'Bearer ' + config.api_key,
        'Accept': 'application/json',
        'Content-Type': 'multipart/form-data',
        'Access-Control-Allow-Origin': '*'
      },
      mode: 'no-cors',
      data: formData,
    }).then((res) => {
      console.log(res);
    });
  };

  return (
    <ChakraProvider theme={theme}>
      <Container>
        <Box textAlign='center' fontSize='xl'>
          <Grid minH='100vh' p={3}>
            <VStack spacing={8}>
              <Text>{config.api_key}</Text>

              <FileUploader
                onFileSelectSuccess={(file) => setSelectedFile(file)}
                onFileSelectError={({ error }) => alert(error)}
              />
              {/*<Input type="file" placeholder="Basic usage" onInput={(file) => { setFile(file); }} ref={this.fileInput}/>*/}

              <Button colorScheme='teal' size='md' onClick={() => {
                submitFileScan();
              }}>
                Scan!
              </Button>
            </VStack>
          </Grid>
        </Box>
      </Container>
    </ChakraProvider>
  );
}

export default App;
