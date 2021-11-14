import React, { useCallback } from 'react';
import {
  ChakraProvider,
  Box,
  Text,
  Link,
  VStack,
  Code,
  Grid,
  theme,
  Button
} from '@chakra-ui/react';
import { ColorModeSwitcher } from './ColorModeSwitcher';
import { Logo } from './Logo';
import config from './config';
import {useDropzone} from 'react-dropzone'


function FileDrop() {
  const onDrop = useCallback(acceptedFiles => {
    let formData = new FormData();
    formData.append('file', acceptedFiles[0]);

    fetch(config.api_url + "/api/scan", {
      method: "POST",
      headers: {
        "Accept": "application/json",
        "Content-Type": "multipart/form-data",
        "Authorization": "Bearer " + config.api_key
      },
      mode:'no-cors',
      body: formData
    }).then((res) => {
      console.log(res);
    })
  }, [])
  const {getRootProps, getInputProps, isDragActive} = useDropzone({onDrop})

  return (
    <div {...getRootProps()}>
      <input {...getInputProps()} />
      {
        isDragActive ?
          <p>Drop the files here ...</p> :
          <p>Drag 'n' drop some files here, or click to select files</p>
      }
    </div>
  )
}

function App() {
  const submitFileScan = () => {
    let formData = new FormData();
    // formData.append('file')


  }

  return (
    <ChakraProvider theme={theme}>
      <Box textAlign="center" fontSize="xl">
        <Grid minH="100vh" p={3}>
          <VStack spacing={8}>
            <Text>{ config.api_key }</Text>
            <FileDrop/>
            <Button colorScheme="teal" size="md" onClick={() => { submitFileScan() }}>
              Scan!
            </Button>
          </VStack>
        </Grid>
      </Box>
    </ChakraProvider>
  );
}

export default App;
