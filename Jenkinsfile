// Workflow

pipeline {
    agent any

    stages {
        stage('Hello') {
            steps {
                echo 'Hello World'
            }
        }
        stage('Check') {
            steps {
                sh 'php --version'
                sh 'composer --version'
            }
        }
        // stage('Checkout Repo') {
        //     steps {
        //         git url: 'https://github.com/monosparta/gohiking-server.git', branch: 'main'
        //         sh 'ls -al'
        //     }
        // }
        stage('Build') {
            sh 'cp .env.example .env'
            sh 'php artisan key:generate'
            sh 'php artisan test'
        }
        stage('Make Zip Artifacts') {
            steps {
                zip zipFile: 'gohiking-server.zip'
            }
        }
    }
    
    post {
        always {
            archiveArtifacts artifacts: '*.json', fingerprint: true
        }
    }
}
